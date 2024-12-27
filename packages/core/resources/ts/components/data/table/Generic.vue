<script lang="ts">
export type Props = {
  meta: TableMeta;
};
</script>

<script setup lang="ts">
import type { SortingState, Table } from "@tanstack/vue-table";
import {
  FlexRender,
  getCoreRowModel,
  useVueTable,
  getSortedRowModel,
} from "@tanstack/vue-table";

import { valueUpdater } from "@/lib/utils";

const { meta } = defineProps<Props>();
defineSlots<{
  description?({ table }: { table: Table<unknown> }): HTMLElement[];
  header?({ table }: { table: Table<unknown> }): HTMLElement[];
  headerActions?({ table }: { table: Table<unknown> }): HTMLElement[];
  title?({ table }: { table: Table<unknown> }): HTMLElement[];
}>();

const sorting = ref<SortingState>([]);

const { getTable } = useTables();
const columns = computed(() => {
  return [
    ...(getTable({ meta })?.columns({
      meta,
    }) ?? []),
  ];
});
const data = computed(() => {
  return [...((getTable({ meta })?.rows as unknown[]) ?? [])];
});

const table = useVueTable({
  data,
  get columns() {
    return columns.value;
  },
  getCoreRowModel: getCoreRowModel(),
  getSortedRowModel: getSortedRowModel(),
  onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
  state: {
    get sorting() {
      return sorting.value;
    },
  },
});
</script>

<template>
  <UiCard>
    <div class="flex justify-between w-full flex-col lg:flex-row">
      <UiCardHeader v-if="$slots.header || $slots.title || $slots.description">
        <slot name="header" v-bind="{ table }">
          <UiCardTitle v-if="$slots.title">
            <slot name="title" v-bind="{ table }" />
          </UiCardTitle>
          <UiCardDescription v-if="$slots.description">
            <slot name="description" v-bind="{ table }" />
          </UiCardDescription>
        </slot>
      </UiCardHeader>
      <div v-else />
      <div
        class="p-6 pt-0 lg:pt-6 grid sm:grid-cols-2 lg:flex items-center gap-2"
      >
        <slot name="headerActions" v-bind="{ table }" />
        <DataTableColumnOptions :table="table" />
      </div>
    </div>
    <UiCardContent>
      <UiTable>
        <UiTableHeader>
          <UiTableRow
            v-for="headerGroup in table.getHeaderGroups()"
            :key="headerGroup.id"
          >
            <UiTableHead v-for="header in headerGroup.headers" :key="header.id">
              <FlexRender
                v-if="!header.isPlaceholder"
                :render="header.column.columnDef.header"
                :props="header.getContext()"
              />
            </UiTableHead>
          </UiTableRow>
        </UiTableHeader>
        <UiTableBody>
          <template v-if="table.getRowModel().rows?.length">
            <UiTableRow
              v-for="row in table.getRowModel().rows"
              :key="row.id"
              :data-state="row.getIsSelected() ? 'selected' : undefined"
            >
              <UiTableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                <FlexRender
                  :render="cell.column.columnDef.cell"
                  :props="cell.getContext()"
                />
              </UiTableCell>
            </UiTableRow>
          </template>
          <template v-else>
            <UiTableRow>
              <UiTableCell :colspan="columns.length" class="h-24 text-center">
                {{ $t("data.table.noData") }}
              </UiTableCell>
            </UiTableRow>
          </template>
        </UiTableBody>
      </UiTable>
    </UiCardContent>
  </UiCard>
</template>
