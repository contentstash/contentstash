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
    <ResourceAttributesDataTable
      :columns="columns"
      :data="modelInfo.attributes"
    />

    <DevCard>
      <DevCardCode title="modelInfo" v-model="modelInfo" />
    </DevCard>
  </DashboardPage>
</template>
