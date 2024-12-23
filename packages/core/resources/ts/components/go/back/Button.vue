<script setup lang="ts">
import { ArrowLeft } from "lucide-vue-next";
defineSlots<{
  default?(): HTMLElement;
}>();
</script>

<template>
  <UiButton variant="secondary">
    <ButtonIcon :icon="ArrowLeft" />
    <slot>
      {{ $t("action.goBack.label") }}
    </slot>
  </UiButton>
</template>
