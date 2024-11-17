<script setup lang="ts">
import type { Table } from "@tanstack/vue-table";
import { computed } from "vue";
// import { type Task } from '../data/schema'
import { SlidersHorizontal } from "lucide-vue-next";

interface DataTableViewOptionsProps {
  table: Table<Task>;
}

const props = defineProps<DataTableViewOptionsProps>();

const columns = computed(() =>
  props.table
    .getAllColumns()
    .filter(
      (column) =>
        typeof column.accessorFn !== "undefined" && column.getCanHide(),
    ),
);
</script>

<template>
  <UiDropdownMenu>
    <UiDropdownMenuTrigger as-child>
      <DataTableActionButton :icon="SlidersHorizontal">
        {{ $t("data.table.columnOptions.button.label") }}
      </DataTableActionButton>
    </UiDropdownMenuTrigger>
    <UiDropdownMenuContent align="end" class="w-[150px]">
      <UiDropdownMenuCheckboxItem
        v-for="column in columns"
        :key="column.id"
        :checked="column.getIsVisible()"
        :min="1"
        @update:checked="(value) => column.toggleVisibility(!!value)"
      >
        {{ column.id }}
      </UiDropdownMenuCheckboxItem>
    </UiDropdownMenuContent>
  </UiDropdownMenu>
</template>
