<script setup lang="ts">
import { getColumns } from "@/components/resource/items/data/table/columns";
const {
  props: { model, modelInfo, items },
}: {
  props: {
    model: Resource;
    modelInfo: ResourceInfo;
    items: {
      data: ResourceItem[];
    };
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
    rows: items.data,
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
      $t('page.dashboard.resources.slug.index.meta.title', {
        modelTitle: title,
      })
    "
  >
    <DashboardPageHeader>
      <template #title>
        {{
          $t("page.dashboard.resources.slug.index.header.title", {
            modelTitle: title,
          })
        }}
      </template>
      <template #description>
        {{ $t("page.dashboard.resources.slug.index.header.description") }}
      </template>
    </DashboardPageHeader>
    <ResourceItemsDataTable :meta="tableMeta" v-model:data="data" />

    <Teleport defer to="#header-alerts">
      <AppAlert type="error">
        <template #title> Attention! </template>
        <template #description>
          Currently there is a limit of 100 items an no pagination. Pagination
          will be implemented after this
          <AppLink
            to="https://github.com/inertiajs/inertia/issues/2068"
            variant="underline"
            >issue</AppLink
          >
          is resolved.
        </template>
      </AppAlert>
    </Teleport>
  </DashboardPage>
</template>
