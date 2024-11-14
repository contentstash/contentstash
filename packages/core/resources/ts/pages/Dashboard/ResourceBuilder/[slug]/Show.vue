<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { columns } from "@/components/resource/model/attributes/columns";
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
  <Head :title="title" />

  <div class="container py-10 mx-auto">
    <ResourceModelAttributesDataTable
      :columns="columns"
      :data="modelInfo.attributes"
    />
  </div>

  <div>
    <pre>
      {{ modelInfo }}
    </pre>
  </div>
</template>
