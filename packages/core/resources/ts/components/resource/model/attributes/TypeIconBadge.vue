<script setup lang="ts">
import {
  Braces,
  CalendarClock,
  CircleHelp,
  Sigma,
  Type,
} from "lucide-vue-next";

const { attribute } = defineProps<{
  attribute: ResourceModelAttribute;
}>();

const { PHP_TYPE, TYPE } = useResourceModelAttribute();

const phpTypeMap: Record<
  ResourceModelAttributePhpType,
  {
    class: string;
    icon: string;
  }
> = {
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
};
const typeMap: Record<
  ResourceModelAttributeType,
  {
    class: string;
    icon: string;
  }
> = {};

const type = computed<{
  class: string;
  icon: string;
}>(() => {
  if (attribute.phpType in phpTypeMap) {
    return phpTypeMap[attribute.phpType];
  } else if (
    attribute.phpType === PHP_TYPE.mixed &&
    attribute.type in typeMap
  ) {
    return typeMap[attribute.type];
  }

  return {
    class: "bg-gray-100 text-gray-700",
    icon: CircleHelp,
  };
});
</script>

<template>
  <div
    :class="type.class"
    class="h-8 w-8 rounded-lg flex items-center justify-center"
  >
    <component :is="type.icon" :size="20" />
  </div>
</template>
