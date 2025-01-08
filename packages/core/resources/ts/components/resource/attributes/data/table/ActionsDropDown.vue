<script setup lang="ts">
import type { Row } from "@tanstack/vue-table";
import { MoreHorizontal, Trash2, Pencil, Undo } from "lucide-vue-next";

const { row, meta } = defineProps<{
  meta: TableMeta;
  row: Row<PartialResourceAttribute>;
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
const { getRow, updateRow, removeRow } = useTables();

// item
const item = computed(
  () => getRow<PartialResourceAttribute>({ uid: meta.uid, index: row.index })!,
);

// edit
const editDialogDrawerOpen = ref(false);
const editDialogDrawerAttribute = ref<PartialResourceAttribute | undefined>();
const selectedAttributeType = ref<AttributeType | undefined>();
const openEditDialogDrawer = () => {
  editDialogDrawerAttribute.value = item.value;
  selectedAttributeType.value = item.value.attributeType;
  editDialogDrawerOpen.value = true;
};
const submitEditHandler = (params: { attribute: PartialResourceAttribute }) => {
  let updatedItem = params.attribute;
  const original =
    item.value.original ?? JSON.parse(JSON.stringify(item.value));

  // check status
  if (item.value.status === PartialResourceAttributeStatus.NEW) {
    // do nothing
  } else {
    // check if any first level attribute is different (except status)
    const attributeKeys = Object.keys(updatedItem).filter(
      (key) => key !== "status",
    );
    const isDifferent = attributeKeys.some((key) => {
      // check if attribute is first level
      if (typeof updatedItem[key] === "object") {
        return false;
      }

      return JSON.stringify(original[key]) !== JSON.stringify(updatedItem[key]);
    });

    if (!isDifferent) {
      updatedItem.status = undefined;
    } else {
      updatedItem.status = PartialResourceAttributeStatus.UPDATED;
    }
  }

  updateRow({
    uid: meta.uid,
    index: row.index,
    row: {
      ...updatedItem,
      original,
    },
  });
};

// undo (by set item to original)
const undoHandler = () => {
  updateRow({
    uid: meta.uid,
    index: row.index,
    row: {
      ...(item.value?.original ?? {}),
      original: undefined,
      status: undefined,
    },
  });
};

// delete
const deleteHandler = () => {
  // if new, remove
  if (item.value.status === PartialResourceAttributeStatus.NEW) {
    removeRow({
      uid: meta.uid,
      index: row.index,
    });
  } else {
    updateRow({
      uid: meta.uid,
      index: row.index,
      row: {
        status: PartialResourceAttributeStatus.DELETED,
      },
    });
  }
};

// restore
const restoreHandler = () => {
  updateRow({
    uid: meta.uid,
    index: row.index,
    row: {
      status: undefined,
    },
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
    <UiDropdownMenuTrigger as-child :disabled="item.locked">
      <UiButton variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">{{ $t("dropdown.menu.trigger.srOnly") }}</span>
        <MoreHorizontal class="w-4 h-4" />
      </UiButton>
    </UiDropdownMenuTrigger>
    <UiDropdownMenuContent align="end">
      <UiDropdownMenuItem
        @click="openEditDialogDrawer"
        :disabled="
          item.status === PartialResourceAttributeStatus.DELETED ||
          !item.attributeType
        "
      >
        <Pencil />
        {{ $t("action.edit.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem
        v-if="item.status === PartialResourceAttributeStatus.UPDATED"
        @click="undoHandler"
      >
        <Undo />
        {{ $t("action.undo.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem
        v-if="item.status !== PartialResourceAttributeStatus.DELETED"
        :disabled="
          item.status === PartialResourceAttributeStatus.UPDATED ||
          !item.attributeType
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
