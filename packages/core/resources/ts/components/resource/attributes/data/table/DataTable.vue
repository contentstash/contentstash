<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef } from "@tanstack/vue-table";
import { Plus } from "lucide-vue-next";

const { uid } = defineProps<{
  uid: string;
  columns: ColumnDef<TData, TValue>[];
}>();
// const data = defineModel("data", {
//   type: Array as PropType<TData[]>,
//   default: [],
// });

const {
  props: { attributeTypes },
}: {
  props: {
    attributeTypes: AttributeType[];
  };
} = usePage();

// const submitResourceAttributeAdd = ({
//   attribute,
// }: {
//   attribute: PartialResourceAttribute;
// }) => {
//   console.info(attribute);

//   // add attribute to data
//   data.value = [...data.value, attribute as TData];
// };
</script>

<template>
  <div>
    <DataTableGeneric :columns="columns" :uid="uid">
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
        <!-- <ResourceAttributeAddEditDialogDrawer
          @submit="submitResourceAttributeAdd"
          :attribute-types="attributeTypes"
        >
          <template #trigger>
            <DataTableActionButton :icon="Plus">
              {{
                $t(
                  "resource.model.attributes.data.table.action.addAttribute.label"
                )
              }}
            </DataTableActionButton>
          </template>
        </ResourceAttributeAddEditDialogDrawer> -->
      </template>
    </DataTableGeneric>
  </div>
</template>
