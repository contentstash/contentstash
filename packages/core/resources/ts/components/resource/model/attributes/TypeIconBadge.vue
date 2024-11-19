<script setup lang="ts">
import {
  Binary,
  Braces,
  CalendarClock,
  CircleHelp,
  Sigma,
  Type,
} from "lucide-vue-next";
import type { LucideIcon } from "lucide-vue-next";
import { type HTMLAttributes } from "vue";
import { cn } from "@/lib/utils";

const { size = "lg", ...props } = defineProps<{
  attribute?: ResourceModelAttribute;
  phpType?: ResourceModelAttributePhpType;
  type?: ResourceModelAttributeType;
  class?: HTMLAttributes["class"];
  size?: "lg";
}>();

const { PHP_TYPE, TYPE } = useResourceModelAttribute();

const phpTypeMap = {
  [PHP_TYPE.int]: {
    class: "bg-blue-100 text-blue-700",
    icon: Sigma,
  },
  [PHP_TYPE.string]: {
    class: "bg-red-100 text-red-700",
    icon: Type,
  },
  [PHP_TYPE.CarbonCarbonInterface]: {
    class: "bg-yellow-100 text-yellow-700",
    icon: CalendarClock,
  },
  [PHP_TYPE.array]: {
    class: "bg-green-100 text-green-700",
    icon: Braces,
  },
  [PHP_TYPE.bool]: {
    class: "bg-purple-100 text-purple-700",
    icon: Binary,
  },
} as Record<ResourceModelAttributePhpType, { class: string; icon: LucideIcon }>;
const typeMap = {} as Record<
  ResourceModelAttributeType,
  {
    class: string;
    icon: LucideIcon;
  }
>;

const type = props?.attribute?.type || props?.type;
const phpType = props?.attribute?.phpType || props?.phpType;

const typeData = computed<{
  class: string;
  icon: LucideIcon;
}>(() => {
  if (phpType && phpType in phpTypeMap) {
    return phpTypeMap[phpType];
  } else if (phpType && type && phpType === PHP_TYPE.mixed && type in typeMap) {
    return typeMap[type];
  }

  return {
    class: "bg-gray-100 text-gray-700",
    icon: CircleHelp,
  };
});
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
        'h-8 w-8 rounded-lg flex items-center justify-center',
        typeData.class,
        sizeClass,
        props.class,
      )
    "
  >
    <component :is="typeData.icon" :size="iconSize" />
  </div>
</template>
