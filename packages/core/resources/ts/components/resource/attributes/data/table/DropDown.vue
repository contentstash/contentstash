<script setup lang="ts">
import type { Table, Row } from "@tanstack/vue-table";
import { MoreHorizontal, Trash2, Pencil, Undo } from "lucide-vue-next";

const { row, table } = defineProps<{
  attribute: PartialResourceAttribute;
  row: Row<PartialResourceAttribute>;
  table: Table<PartialResourceAttribute>;
}>();

const { PartialResourceAttributeStatus } = useResourceAttribute();
const deleteAttribute = () => {
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
const restoreAttribute = () => {
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
  <UiDropdownMenu>
    <UiDropdownMenuTrigger as-child :disabled="attribute.locked">
      <UiButton variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">{{ $t("dropdown.menu.trigger.srOnly") }}</span>
        <MoreHorizontal class="w-4 h-4" />
      </UiButton>
    </UiDropdownMenuTrigger>
    <UiDropdownMenuContent align="end">
      <UiDropdownMenuItem :disabled="true">
        <Pencil />
        {{ $t("action.edit.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem
        v-if="attribute.status !== PartialResourceAttributeStatus.DELETED"
        @click="deleteAttribute"
      >
        <Trash2 />
        {{ $t("action.delete.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem v-else @click="restoreAttribute">
        <Undo />
        {{ $t("action.restore.label") }}
      </UiDropdownMenuItem>
    </UiDropdownMenuContent>
  </UiDropdownMenu>
</template>
