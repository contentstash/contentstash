<script lang="ts">
import type { DefineComponent } from "vue";

export type Props = {
  type?: "default" | "error";
  icon?: DefineComponent;
  hideIcon?: boolean;
};
</script>

<script setup lang="ts">
import { ExclamationTriangleIcon } from "@radix-icons/vue";
import { Rocket } from "lucide-vue-next";

const { type = "default", hideIcon = false, ...props } = defineProps<Props>();
defineSlots<{
  title?: HTMLElement[];
  description?: HTMLElement[];
}>();

const icon = computed(() => {
  if (props.icon) {
    return props.icon;
  }

  switch (type) {
    case "error":
      return ExclamationTriangleIcon;
    default:
      return Rocket;
  }
});
const variant = computed(() => {
  switch (type) {
    case "error":
      return "destructive";
    default:
      return "default";
  }
});
</script>

<template>
  <UiAlert :variant="variant">
    <component v-if="!hideIcon" :is="icon" class="w-4 h-4" />
    <UiAlertTitle>
      <slot name="title">
        {{ $t(`alert.${type}.title`) }}
      </slot>
    </UiAlertTitle>
    <UiAlertDescription v-if="$slots.description">
      <slot name="description" />
    </UiAlertDescription>
  </UiAlert>
</template>
