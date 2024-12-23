<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef } from "@tanstack/vue-table";
import { Plus } from "lucide-vue-next";

defineProps<{
  columns: ColumnDef<TData, TValue>[];
  data: TData[];
}>();

const {
  props: { attributeTypes },
}: {
  props: {
    attributeTypes: AttributeType[];
  };
} = usePage();

const temp = ref(true);
</script>

<template>
  <div>
    <DataTableGeneric :columns="columns" :data="data">
      <template #title>
        {{ $t("resource.model.attributes.data.table.title") }}
      </template>
      <template #description="{ table }">
        {{
          $t("resource.model.attributes.data.table.description", {
            count: table.getRowModel().rows?.length,
          })
        }}
      </template>
      <template #headerActions>
        <ResourceAttributeAddEditDialogDrawer
          v-model:open="temp"
          :attribute-types="attributeTypes"
        >
          <template #trigger>
            <DataTableActionButton :icon="Plus">
              {{
                $t(
                  "resource.model.attributes.data.table.action.addAttribute.label",
                )
              }}
            </DataTableActionButton>
          </template>
        </ResourceAttributeAddEditDialogDrawer>
      </template>
    </DataTableGeneric>
  </div>
</template>
