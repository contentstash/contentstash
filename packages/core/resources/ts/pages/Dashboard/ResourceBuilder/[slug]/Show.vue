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
const { PartialResourceAttributeStatus } = useResourceAttribute();
const data = ref<PartialResourceAttribute[]>(modelInfo.attributes);
const originalData = JSON.parse(JSON.stringify(data.value));
const changedData = computed<{
  new: PartialResourceAttribute[];
  updated: PartialResourceAttribute[];
  deleted: PartialResourceAttribute[];
}>(() => {
  const newAttributes = data.value.filter(
    (attribute) => attribute.status === PartialResourceAttributeStatus.NEW,
  );
  const updatedAttributes = data.value.filter(
    (attribute) => attribute.status === PartialResourceAttributeStatus.UPDATED,
  );
  const deletedAttributes = data.value.filter(
    (attribute) => attribute.status === PartialResourceAttributeStatus.DELETED,
  );

  return {
    new: newAttributes,
    updated: updatedAttributes,
    deleted: deletedAttributes,
  };
});
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
    <ResourceAttributesDataTable :columns="columns" v-model:data="data" />

    <DevCard>
      <DevCardCode title="originalData" v-model="originalData" />
      <DevCardCode title="changedData" v-model="changedData" />
      <DevCardCode title="data" v-model="data" />
      <DevCardCode title="modelInfo" v-model="modelInfo" />
    </DevCard>
  </DashboardPage>
</template>
