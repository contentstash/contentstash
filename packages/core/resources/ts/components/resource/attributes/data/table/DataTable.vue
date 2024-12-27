<script setup lang="ts">
import type { Props } from "@/components/data/table/Generic.vue";
import { Plus } from "lucide-vue-next";

const { meta, ...props } = defineProps<Props>();
const {
  props: { attributeTypes },
}: {
  props: {
    attributeTypes: AttributeType[];
  };
} = usePage();

// add attribute
const { addRow } = useTables();
const submitResourceAttributeAdd = ({
  attribute,
}: {
  attribute: PartialResourceAttribute;
}) => {
  // add attribute to data
  addRow<ResourceAttribute>({
    meta,
    row: attribute as ResourceAttribute,
  });
};
</script>

<template>
  <div>
    <DataTableGeneric
      v-bind="{
        ...props,
        meta,
      }"
    >
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
          @submit="submitResourceAttributeAdd"
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
