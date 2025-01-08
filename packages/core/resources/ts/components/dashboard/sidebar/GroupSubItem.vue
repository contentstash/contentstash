<script setup lang="ts">
import type { SidebarSubItem } from "@/components/dashboard/sidebar/Group.vue";
import { useSidebar } from "@/components/ui/sidebar/utils";
import UiDropdownMenuItem from "@/components/ui/dropdown-menu/DropdownMenuItem.vue";
import UiSidebarMenuSubItem from "@/components/ui/sidebar/SidebarMenuSubItem.vue";
import UiSidebarMenuAction from "@/components/ui/sidebar/SidebarMenuAction.vue";

defineProps<{
  items: SidebarSubItem[];
}>();

const { isI18nString } = useI18nString();
const { isMobile, state } = useSidebar();
</script>

<template>
  <component
    :is="state == 'expanded' || isMobile ? UiSidebarMenuSubItem : 'div'"
    v-for="subItem in items"
    :key="subItem.title"
  >
    <UiSidebarMenuSubButton
      as-child
      :class="{
        'text-muted-foreground hover:text-muted-foreground hover:cursor-not-allowed':
          subItem.disabled,
      }"
    >
      <AppLink :to="subItem.to" :disabled="subItem.disabled">
        <span>{{
          isI18nString(subItem.title) ? $t(subItem.title) : subItem.title
        }}</span>
      </AppLink>
    </UiSidebarMenuSubButton>
  </component>
</template>
