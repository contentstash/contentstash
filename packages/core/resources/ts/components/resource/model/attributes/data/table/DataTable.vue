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
        {{ $t("resource.model.attributes.dataTable.title") }}
      </template>
      <template #description="{ table }">
        {{
          $t("resource.model.attributes.dataTable.description", {
            count: table.getRowModel().rows?.length,
          })
        }}
      </template>
      <template #headerActions>
        <DataTableActionButton :icon="Plus" :disabled="true">
          {{
            $t("resource.model.attributes.dataTable.action.addAttribute.label")
          }}
        </DataTableActionButton>
      </template>
    </DataTableGeneric>
  </div>
</template>
