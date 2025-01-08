<script setup lang="ts">
import { getColumns } from "@/components/resource/items/data/table/columns";
const {
  props: { model, modelInfo, items },
}: {
  props: {
    model: Resource;
    modelInfo: ResourceInfo;
    items: ResourceItem[];
  };
} = usePage();

const title = computed(() => {
  return model.split("\\").pop();
});

const { getItemDataTableColumn } = useResourceAttribute();
const getResourceColumns: TableColumns<ResourceItem> = () => {
  return modelInfo.attributes
    .filter((attribute) => !attribute.hidden)
    .map((attribute) => {
      return getItemDataTableColumn({ attribute });
    });
};

// table
const { setTable, getTable } = useTables();
const tableMeta = setTable<ResourceItem, ResourceItem>({
  uid: `${useRoute().current()}-resource-items-data-table`,
  table: {
    rows: items,
    columns: [getResourceColumns, getColumns],
  },
});

const data = computed(() => {
  return getTable<unknown, ResourceItem>({ meta: tableMeta })?.rows ?? [];
});
</script>

<template>
  <DashboardPage
    :title="
      $t('page.dashboard.resources.slug.show.meta.title', {
        modelTitle: title,
      })
    "
  >
    <DashboardPageHeader>
      <template #title>
        {{
          $t("page.dashboard.resources.slug.show.header.title", {
            modelTitle: title,
          })
        }}
      </template>
      <template #description>
        {{ $t("page.dashboard.resources.slug.show.header.description") }}
      </template>
    </DashboardPageHeader>
    <ResourceItemsDataTable :meta="tableMeta" v-model:data="data" />
  </DashboardPage>
</template>
