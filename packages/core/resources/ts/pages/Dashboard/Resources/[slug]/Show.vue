<script setup lang="ts">
import { columns } from "@/components/resource/items/data/table/columns";
const {
  props: { model, modelInfo, items },
}: {
  props: {
    model: ResourceModel;
    modelInfo: ResourceModelInfo;
    items: ResourceItem[];
  };
} = usePage();

const title = computed(() => {
  return model.split("\\").pop();
});

const { getItemDataTableColumn } = useResourceModelAttribute();
const resourceColumns = computed(() => {
  return modelInfo.attributes
    .filter((attribute) => !attribute.hidden)
    .map((attribute) => {
      return getItemDataTableColumn({ attribute });
    });
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
    <ResourceItemsDataTable
      :columns="[...resourceColumns, ...columns]"
      :data="items"
    />
  </DashboardPage>
</template>
