<script setup lang="ts">
import { Save } from "lucide-vue-next";
defineSlots<{
  default?(): HTMLElement;
}>();
</script>

<template>
  <UiButton>
    <ButtonIcon :icon="Save" />
    <slot>
      {{ $t("action.save.label") }}
    </slot>
  </UiButton>
</template>
