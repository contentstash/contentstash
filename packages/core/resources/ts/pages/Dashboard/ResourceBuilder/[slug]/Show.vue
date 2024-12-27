<script setup lang="ts">
import { columns } from "@/components/resource/attributes/data/table/columns";
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
// const data = ref<PartialResourceAttribute[]>(modelInfo.attributes);

const TABLE_UID = `${useRoute().current()}-resource-attributes-data-table`;
const { setTable, getTable, addRow, updateRow, removeRow } = useTables();
const tableMeta = setTable<unknown, PartialResourceAttribute>({
  uid: TABLE_UID,
  table: {
    rows: modelInfo.attributes,
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

const test2 = () => {
  // get an random row
  const rowIndex = Math.floor(Math.random() * data.value.length);
  const row = data.value[rowIndex];

  // reverse the name of the row
  updateRow({
    meta: tableMeta,
    index: rowIndex,
    row: {
      ...row,
      name: row.name?.split("").reverse().join(""),
    },
  });
};

const test3 = () => {
  // get an random row index
  const index = Math.floor(Math.random() * data.value.length);

  // remove the row
  removeRow({
    meta: tableMeta,
    index,
  });
};
</script>

<template>
  {{ TABLE_UID }}
  {{ tableMeta }}
  <UiButton @click="test">Add Random Row</UiButton>
  <UiButton @click="test2">Update Random Row</UiButton>
  <UiButton @click="test3">Remove Random Row</UiButton>
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
    <ResourceAttributesDataTable
      :uid="TABLE_UID"
      :columns="columns"
      v-model:data="data"
    />

    <DevCard>
      <DevCardCode title="data" v-model="data" />
      <DevCardCode title="modelInfo" v-model="modelInfo" />
    </DevCard>
  </DashboardPage>
</template>
