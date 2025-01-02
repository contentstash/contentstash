<script setup lang="ts">
import { getColumns } from "@/components/resource/attributes/data/table/columns";
const {
  props: { slug, model, modelInfo },
}: {
  props: {
    slug: string;
    model: Resource;
    modelInfo: ResourceInfo;
  };
} = usePage();

const title = computed(() => {
  return model.split("\\").pop();
});

// table
const { setTable, getTable } = useTables();
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
const { PartialResourceAttributeStatus } = useResourceAttribute();
const formData = computed(() => {
  return data.value
    .filter((row) => row.status !== PartialResourceAttributeStatus.DELETED)
    .reduce(
      (acc, row) => {
        const key = (row.original?.name as string) ?? row.name;
        const { original, status, locked, ...rest } = row;
        acc[key] = {
          ...rest,
          attributeType: row.attributeType.name,
        };
        return acc;
      },
      // TODO: add type
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      {} as Record<string, any>,
    );
});

const temp = useRoute("dashboard.resource-builder.slug.update", { slug });
const saveHandler = () => {
  useRouter().put(temp, {
    data: formData.value,
  });
};

// const { getRow, updateRow, addRow } = useTables();
// onMounted(() => {
//   updateRow<PartialResourceAttribute>({
//     meta: tableMeta,
//     index: data.value.length - 2,
//     row: {
//       status: PartialResourceAttributeStatus.DELETED,
//     } as PartialResourceAttribute,
//   });

//   const secondRow = getRow<PartialResourceAttribute>({
//     meta: tableMeta,
//     index: 1,
//   });
//   addRow<PartialResourceAttribute>({
//     meta: tableMeta,
//     row: {
//       ...secondRow,
//       name: "new_row",
//       status: PartialResourceAttributeStatus.NEW,
//     } as PartialResourceAttribute,
//   });

//   updateRow<PartialResourceAttribute>({
//     meta: tableMeta,
//     index: 1,
//     row: {
//       ...secondRow,
//       name: "updated_title",
//       status: PartialResourceAttributeStatus.UPDATED,
//       nullable: true,
//       original: JSON.parse(JSON.stringify(secondRow)),
//     } as PartialResourceAttribute,
//   });

//   setTimeout(() => saveHandler(), 500);
// });
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

    <UiButton @click="saveHandler()">SAVE</UiButton>

    <DevCard>
      <DevCardCode title="formData" v-model="formData" />
      <DevCardCode title="data" v-model="data" />
      <DevCardCode title="modelInfo" v-model="modelInfo" />
    </DevCard>
  </DashboardPage>
</template>
