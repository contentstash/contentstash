<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef } from "@tanstack/vue-table";
import { Plus } from "lucide-vue-next";

defineProps<{
  columns: ColumnDef<TData, TValue>[];
  data: TData[];
}>();
</script>

<template>
  <div>
    <DataTableGeneric :columns="columns" :data="data">
      <template #title>
        {{ $t("resource.items.data.table.title") }}
      </template>
      <template #description="{ table }">
        {{
          $t("resource.items.data.table.description", {
            count: table.getRowModel().rows?.length,
          })
        }}
      </template>
      <template #headerActions>
        <DataTableActionButton :icon="Plus" :disabled="true">
          {{ $t("resource.items.data.table.action.addItem.label") }}
        </DataTableActionButton>
      </template>
    </DataTableGeneric>
  </div>
</template>
