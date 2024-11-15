<script setup lang="ts">
import { columns } from "@/components/resource/model/attributes/data/table/columns";
const {
  props: { model, modelInfo },
}: {
  props: {
    model: ResourceModel;
    modelInfo: ResourceModelInfo;
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
    <ResourceModelAttributesDataTable
      :columns="columns"
      :data="modelInfo.attributes"
    />

    <!-- <div class="overflow-x w-10">
    <pre>
      {{ modelInfo }}
    </pre>
  </div> -->
  </DashboardPage>
</template>
