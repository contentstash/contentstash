<script setup lang="ts">
import Tooltip from "@/components/ui/tooltip/Tooltip.vue";
import TooltipContent from "@/components/ui/tooltip/TooltipContent.vue";
import TooltipTrigger from "@/components/ui/tooltip/TooltipTrigger.vue";
import { type Component, computed } from "vue";
import SidebarMenuButtonChild, {
  type SidebarMenuButtonProps,
} from "./SidebarMenuButtonChild.vue";
import { useSidebar } from "./utils";
import { router } from "@inertiajs/vue3";

defineOptions({
  inheritAttrs: false,
});

const props = withDefaults(
  defineProps<
    SidebarMenuButtonProps & {
      tooltip?: string | Component;
    }
  >(),
  {
    as: "button",
    variant: "default",
    size: "default",
  },
);

const { isMobile, state } = useSidebar();

const delegatedProps = computed(() => {
  const { tooltip, ...delegated } = props;
  return delegated;
});

const tooltipIsOpen = ref(false);
const removeStartEventListener = router.on("start", (event) => {
  tooltipIsOpen.value = false;
});
onBeforeUnmount(() => {
  removeStartEventListener();
});
</script>

<template>
  <SidebarMenuButtonChild
    v-if="!tooltip"
    v-bind="{ ...delegatedProps, ...$attrs }"
  >
    <slot />
  </SidebarMenuButtonChild>
  <Tooltip
    v-else
    v-model:open="tooltipIsOpen"
    :ignore-non-keyboard-focus="true"
  >
    <TooltipTrigger as-child>
      <SidebarMenuButtonChild v-bind="{ ...delegatedProps, ...$attrs }">
        <slot />
      </SidebarMenuButtonChild>
    </TooltipTrigger>
    <TooltipContent
      side="right"
      align="center"
      :hidden="state !== 'collapsed' || isMobile || !tooltipIsOpen"
    >
      <template v-if="typeof tooltip === 'string'">
        {{ tooltip }}
      </template>
      <component :is="tooltip" v-else />
    </TooltipContent>
  </Tooltip>
</template>
