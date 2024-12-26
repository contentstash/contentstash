<script setup lang="ts">
import type { Table, Row } from "@tanstack/vue-table";
import { MoreHorizontal, Trash2, Pencil, Undo } from "lucide-vue-next";

const { attribute, row, table } = defineProps<{
  attribute: PartialResourceAttribute;
  row: Row<PartialResourceAttribute>;
  table: Table<PartialResourceAttribute>;
}>();
const {
  props: { attributeTypes },
}: {
  props: {
    attributeTypes: AttributeType[];
  };
} = usePage();

// general
const { PartialResourceAttributeStatus } = useResourceAttribute();

// edit
const editDialogDrawerOpen = ref(false);
const editDialogDrawerAttribute = ref<PartialResourceAttribute | undefined>();
const selectedAttributeType = ref<AttributeType | undefined>();
const openEditDialogDrawer = () => {
  editDialogDrawerAttribute.value = attribute;
  selectedAttributeType.value = attribute.attributeType;
  editDialogDrawerOpen.value = true;
};
const submitEditHandler = (params: { attribute: PartialResourceAttribute }) => {
  const data = table.options.data;

  const item = data[row.index];
  item.original = item.original
    ? item.original
    : JSON.parse(JSON.stringify(item));

  // check status
  if (item.status === PartialResourceAttributeStatus.NEW) {
    // do nothing
  } else {
    // check if any first level attribute is different (except status)
    const attributeKeys = Object.keys(params.attribute).filter(
      (key) => key !== "status",
    );
    const isDifferent = attributeKeys.some((key) => {
      // check if attribute is first level
      if (typeof params.attribute[key] === "object") {
        return false;
      }

      return (
        JSON.stringify(item?.original?.[key]) !==
        JSON.stringify(params.attribute[key])
      );
    });

    if (!isDifferent) {
      item.status = undefined;
    } else {
      item.status = PartialResourceAttributeStatus.UPDATED;
    }
  }

  // update item
  const { status, ...rest } = params.attribute;
  Object.assign(item, {
    ...rest,
  });

  data[row.index] = item;
  table.setOptions((prev) => {
    return {
      ...prev,
      data: [...data],
    };
  });
};

// undo (by set item to original)
const undoHandler = () => {
  const data = table.options.data;

  const item = data[row.index];
  const original = item.original;
  Object.assign(item, {
    ...original,
  });
  item.original = undefined;
  item.status = undefined;

  data[row.index] = item;
  table.setOptions((prev) => {
    return {
      ...prev,
      data: [...data],
    };
  });
};

// delete
const deleteHandler = () => {
  const data = table.options.data;

  const item = data[row.index];
  item.status = PartialResourceAttributeStatus.DELETED;

  data[row.index] = item;
  table.setOptions((prev) => {
    return {
      ...prev,
      data: [...data],
    };
  });
};

// restore
const restoreHandler = () => {
  const data = table.options.data;

  const item = data[row.index];
  item.status = undefined;

  data[row.index] = item;
  table.setOptions((prev) => {
    return {
      ...prev,
      data: [...data],
    };
  });
};
</script>

<template>
  <ResourceAttributeAddEditDialogDrawer
    v-model:open="editDialogDrawerOpen"
    v-model:selected-attribute-type="selectedAttributeType"
    @submit="submitEditHandler"
    v-model:attribute="editDialogDrawerAttribute"
    :attribute-types="attributeTypes"
  />
  <UiDropdownMenu>
    <UiDropdownMenuTrigger as-child :disabled="attribute.locked">
      <UiButton variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">{{ $t("dropdown.menu.trigger.srOnly") }}</span>
        <MoreHorizontal class="w-4 h-4" />
      </UiButton>
    </UiDropdownMenuTrigger>
    <UiDropdownMenuContent align="end">
      <UiDropdownMenuItem
        @click="openEditDialogDrawer"
        :disabled="attribute.status === PartialResourceAttributeStatus.DELETED"
      >
        <Pencil />
        {{ $t("action.edit.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem
        v-if="attribute.status === PartialResourceAttributeStatus.UPDATED"
        @click="undoHandler"
      >
        <Undo />
        {{ $t("action.undo.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem
        v-if="attribute.status !== PartialResourceAttributeStatus.DELETED"
        :disabled="
          attribute.status === PartialResourceAttributeStatus.NEW ||
          attribute.status === PartialResourceAttributeStatus.UPDATED
        "
        @click="deleteHandler"
      >
        <Trash2 />
        {{ $t("action.delete.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem v-else @click="restoreHandler">
        <Undo />
        {{ $t("action.restore.label") }}
      </UiDropdownMenuItem>
    </UiDropdownMenuContent>
  </UiDropdownMenu>
</template>
