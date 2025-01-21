<script setup lang="ts">
import type { FunctionalComponent } from "vue";
import AppLink from "@/components/app/Link.vue";

defineProps<{
  icon?: FunctionalComponent;
  to?: Route | string;
}>();
</script>

<template>
  <UiButton
    variant="outline"
    size="sm"
    class="h-8 flex"
    :as="to ? AppLink : undefined"
    :to="to"
  >
    <ButtonIcon v-if="icon" :icon="icon" :size="24" />
    <slot />
  </UiButton>
</template>
