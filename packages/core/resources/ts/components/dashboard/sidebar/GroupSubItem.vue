<script setup lang="ts">
import { ChevronRight, Plus } from "lucide-vue-next";
import type { SidebarSubItem } from "@/components/dashboard/sidebar/Group.vue";

defineProps<{
  items: SidebarSubItem[];
}>();

const { isI18nString } = useI18nString();
</script>

<template>
  <UiSidebarMenuSubItem v-for="subItem in items" :key="subItem.title">
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
  </UiSidebarMenuSubItem>
</template>
