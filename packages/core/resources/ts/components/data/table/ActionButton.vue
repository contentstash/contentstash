<script setup lang="ts">
import type { FunctionalComponent } from "vue";

defineProps<{
  icon?: FunctionalComponent;
}>();
</script>

<template>
  <UiButton variant="outline" size="sm" class="h-8 flex">
    <ButtonIcon v-if="icon" :icon="icon" :size="24" />
    <slot />
  </UiButton>
</template>
