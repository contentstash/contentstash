<script setup lang="ts">
import type { FunctionalComponent } from "vue";

defineProps<{
  icon?: FunctionalComponent;
}>();
</script>

<template>
  <UiButton variant="outline" size="sm" class="hidden h-8 ml-auto lg:flex">
    <component v-if="icon" :is="icon" class="w-4 h-4 mr-2" />
    <slot />
  </UiButton>
</template>
