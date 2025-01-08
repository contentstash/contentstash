<script lang="ts">
export type Props = {
  icon: Component;
  size?: number;
  class?: string;
};
</script>

<script setup lang="ts">
import { cn } from "@/lib/utils";

const { size = 24, icon: iconComponent, ...props } = defineProps<Props>();
</script>

<template>
  <component
    :is="iconComponent"
    :size="size"
    :class="cn('w-4 h-4 mr-1', props.class)"
  />
</template>
