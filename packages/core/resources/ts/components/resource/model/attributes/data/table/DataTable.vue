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
                v-for="(attributeType, index) in attributeTypes"
                :key="index"
                class="border hover:bg-muted p-3 rounded-lg hover:cursor-pointer"
              >
                <div class="flex items-center gap-2">
                  <AttributeTypeLucideIconBadge
                    v-if="attributeType.icon"
                    :icon="attributeType.icon"
                    :class="attributeType.classes?.badge"
                  />
                  <span class="ml-2">{{ attributeType.name }}</span>
                </div>
              </li>
            </ul>
          </template>
        </DialogDrawer>
      </template>
    </DataTableGeneric>
  </div>
</template>
