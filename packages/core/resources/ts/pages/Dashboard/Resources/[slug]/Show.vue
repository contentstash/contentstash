<script setup lang="ts">
import { Head } from "@inertiajs/vue3";

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

  <div>
    <pre>
      {{ model }}
    </pre>
  </div>
</template>
