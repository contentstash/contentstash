<script setup lang="ts">
import { CalendarClock, Sigma, Type } from "lucide-vue-next";

const { type } = defineProps<{
  type: ResourceModelAttributePhpType;
}>();

const typeClass: Record<ResourceModelAttributePhpType, string> = {
  int: "bg-blue-100 text-blue-700",
  string: "bg-red-100 text-red-700",
  "\\Carbon\\CarbonInterface": "bg-yellow-100 text-yellow-700",
};

const typeIcon: Record<ResourceModelAttributePhpType, string> = {
  int: Sigma,
  string: Type,
  "\\Carbon\\CarbonInterface": CalendarClock,
};
</script>

<template>
  <div
    :class="typeClass[type]"
    class="h-8 w-8 rounded-lg flex items-center justify-center"
  >
    <component :is="typeIcon[type]" :size="20" />
  </div>
</template>
