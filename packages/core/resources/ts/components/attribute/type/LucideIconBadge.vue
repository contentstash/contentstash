<script lang="ts">
import type { Props as BaseProp } from "@/components/attribute/type/BaseBadge.vue";

export type Props = BaseProp & {
  icon?: string | Component;
};
</script>

<script setup lang="ts">
import * as icons from "lucide-vue-next";
const { size = "lg", icon = "CircleHelp", ...props } = defineProps<Props>();

const iconSize = computed(() => {
  switch (size) {
    default: // lg
      return 24;
  }
});

const iconComponent = computed(() => {
  if (typeof icon === "string" && icon in icons) {
    return (icons as unknown as Record<string, Component>)[icon];
  }

  return icon;
});
</script>

<template>
  <AttributeTypeBaseBadge
    v-bind="{
      ...props,
      size,
    }"
  >
    <component :is="iconComponent" :size="iconSize" />
  </AttributeTypeBaseBadge>
</template>
