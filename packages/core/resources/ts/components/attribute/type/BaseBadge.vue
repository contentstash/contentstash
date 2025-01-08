<script lang="ts">
import { type HTMLAttributes } from "vue";

export type Props = {
  attribute?: ResourceAttribute;
  class?: HTMLAttributes["class"];
  size?: "lg";
};
</script>

<script setup lang="ts">
import { cn } from "@/lib/utils";

const { size = "lg", ...props } = defineProps<Props>();

const sizeClass = computed(() => {
  switch (size) {
    default: // lg
      return "h-8 w-8";
  }
});
const iconSize = computed(() => {
  switch (size) {
    default: // lg
      return 24;
  }
});
</script>

<template>
  <div
    :class="
      cn(
        'h-8 w-8 rounded-lg flex items-center justify-center bg-gray-100 text-gray-700',
        sizeClass,
        props.class,
      )
    "
  >
    <slot />
  </div>
</template>
