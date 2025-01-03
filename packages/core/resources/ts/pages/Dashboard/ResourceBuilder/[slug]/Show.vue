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
          attributeType: row.attributeType?.name ?? "unknown",
        };
        return acc;
      },
      // TODO: add type
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      {} as Record<string, any>,
    );
});

// update
const updateButtonIsDisabled = computed(() => {
  return !data.value.some((row) => row.status);
});
const updateRoute = useRoute("dashboard.resource-builder.slug.update", {
  slug,
});
const updateHandler = () => {
  useRouter().put(updateRoute, {
    data: formData.value,
  });
};

// destroy
const destroyRoute = useRoute("dashboard.resource-builder.slug.destroy", {
  slug,
});
const destroyHandler = () => {
  useRouter().delete(destroyRoute);
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

    <div class="flex justify-end gap-2">
      <UiButton @click="updateHandler()" :disabled="updateButtonIsDisabled">
        {{
          $t("page.dashboard.resource-builder.slug.show.action.update.label")
        }}
      </UiButton>
      <UiButton @click="destroyHandler()" variant="destructive">
        {{
          $t("page.dashboard.resource-builder.slug.show.action.destroy.label")
        }}
      </UiButton>
    </div>

    <DevCard>
      <DevCardCode title="formData" v-model="formData" />
      <DevCardCode title="data" v-model="data" />
      <DevCardCode title="modelInfo" v-model="modelInfo" />
    </DevCard>
  </DashboardPage>
</template>
