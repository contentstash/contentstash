<script setup lang="ts">
import { Head } from "@inertiajs/vue3";

defineProps<{
  title: string;
}>();
</script>

<template>
  <Head :title="title" />
  <div class="flex flex-col gap-4">
    <slot />
  </div>
</template>
