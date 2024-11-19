<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef } from "@tanstack/vue-table";
import { Plus } from "lucide-vue-next";

defineProps<{
  columns: ColumnDef<TData, TValue>[];
  data: TData[];
}>();

const { PHP_TYPE, TYPE } = useResourceModelAttribute();

const typeMap: {
  phpType: ResourceModelAttributePhpType;
  type?: ResourceModelAttributeType;
}[] = [
  {
    phpType: PHP_TYPE.int,
  },
  {
    phpType: PHP_TYPE.string,
  },
  {
    phpType: PHP_TYPE.CarbonCarbonInterface,
  },
  {
    phpType: PHP_TYPE.bool,
  },
  {
    phpType: PHP_TYPE.array,
  },
];
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
        <DialogDrawer>
          <template #trigger>
            <DataTableActionButton :icon="Plus">
              {{
                $t(
                  "resource.model.attributes.data.table.action.addAttribute.label",
                )
              }}
            </DataTableActionButton>
          </template>
          <template #title>
            {{ $t("foo.bar.title") }}
          </template>
          <template #description>
            {{ $t("foo.bar.description") }}
          </template>
          <template #default>
            <ul class="grid sm:grid-cols-2 gap-2">
              <li
                v-for="(type, index) in typeMap"
                :key="index"
                class="border hover:bg-muted p-3 rounded-lg hover:cursor-pointer"
              >
                <div class="flex items-center gap-2">
                  <ResourceModelAttributesTypeIconBadge
                    :type="type.type"
                    :phpType="type.phpType"
                    class="flex-shrink-0"
                  />
                  <span class="ml-2">{{ type.phpType ?? type.type }}</span>
                </div>
              </li>
            </ul>
          </template>
        </DialogDrawer>
      </template>
    </DataTableGeneric>
  </div>
</template>
