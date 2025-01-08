<script setup lang="ts" generic="TData, TValue">
import type { Props } from "@/components/data/table/Generic.vue";
import { Plus } from "lucide-vue-next";

const props = defineProps<Props>();
</script>

<template>
  <div>
    <DataTableGeneric v-bind="props">
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
