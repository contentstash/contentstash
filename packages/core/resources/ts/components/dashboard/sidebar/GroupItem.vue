<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { useSidebar } from "@/components/ui/sidebar/utils";

defineProps<{
  defaultOpen?: boolean;
}>();
defineSlots<{
  trigger: HTMLElement[];
  content?: HTMLElement[];
}>();

const { isMobile, state } = useSidebar();

const dropdownMenuIsOpen = ref(false);
const removeStartEventListener = router.on("start", (event) => {
  dropdownMenuIsOpen.value = false;
});
onBeforeUnmount(() => {
  removeStartEventListener();
});
</script>

<template>
  <div class="relative">
    <UiSidebarMenuItem v-if="!$slots.content">
      <slot name="trigger" />
    </UiSidebarMenuItem>
    <UiCollapsible
      v-else-if="state == 'expanded' || isMobile"
      as-child
      class="group/collapsible"
      :default-open="defaultOpen"
    >
      <UiSidebarMenuItem>
        <UiCollapsibleTrigger as-child>
          <slot name="trigger" />
        </UiCollapsibleTrigger>
      </UiSidebarMenuItem>

      <UiCollapsibleContent>
        <UiSidebarMenuSub>
          <slot name="content" />
        </UiSidebarMenuSub>
      </UiCollapsibleContent>
    </UiCollapsible>
    <UiDropdownMenu v-else as-child v-model:open="dropdownMenuIsOpen">
      <UiSidebarMenuItem>
        <UiDropdownMenuTrigger asChild>
          <slot name="trigger" />
        </UiDropdownMenuTrigger>
      </UiSidebarMenuItem>

      <UiDropdownMenuContent side="right" align="start">
        <slot name="content" />
      </UiDropdownMenuContent>
    </UiDropdownMenu>
  </div>
</template>
