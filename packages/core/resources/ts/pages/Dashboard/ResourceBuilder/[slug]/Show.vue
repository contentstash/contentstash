<script setup lang="ts">
import { getColumns } from "@/components/resource/attributes/data/table/columns";
const {
  props: { model, modelInfo },
}: {
  props: {
    model: Resource;
    modelInfo: ResourceInfo;
  };
} = usePage();

const title = computed(() => {
  return model.split("\\").pop();
});

// table
const { setTable, getTable, addRow } = useTables();
const tableMeta = setTable<PartialResourceAttribute, PartialResourceAttribute>({
  uid: `${useRoute().current()}-resource-attributes-data-table`,
  table: {
    rows: modelInfo.attributes,
    columns: getColumns,
  },
});

const data = computed(() => {
  return (
    getTable<unknown, PartialResourceAttribute>({ meta: tableMeta })?.rows ?? []
  );
});

const test = () => {
  // get an random row
  const row = data.value[Math.floor(Math.random() * data.value.length)];

  // add a row with an random name
  addRow<PartialResourceAttribute>({
    meta: tableMeta,
    row: {
      ...row,
      name: `Random ${Math.floor(Math.random() * 1000)}`,
    },
  });
};
</script>

<template>
  <DashboardPage
    :title="
      $t('page.dashboard.resource-builder.slug.show.meta.title', {
        modelTitle: title,
      })
    "
  >
    <DashboardPageHeader>
      <template #title>
        {{
          $t("page.dashboard.resource-builder.slug.show.header.title", {
            modelTitle: title,
          })
        }}
      </template>
      <template #description>
        {{ $t("page.dashboard.resource-builder.slug.show.header.description") }}
      </template>
    </DashboardPageHeader>
    <ResourceAttributesDataTable :meta="tableMeta" v-model:data="data" />

    <DevCard>
      <DevCardCode title="data" v-model="data" />
      <DevCardCode title="modelInfo" v-model="modelInfo" />
    </DevCard>
  </DashboardPage>
</template>
