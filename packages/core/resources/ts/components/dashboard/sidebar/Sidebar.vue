<script setup lang="ts">
import type { SidebarItem } from "@/components/dashboard/sidebar/Group.vue";

defineProps<{
  groups: {
    label?: string;
    items: SidebarItem[];
  }[];
}>();
</script>

<template>
  <UiSidebarProvider>
    <UiSidebar collapsible="icon">
      <DashboardSidebarHeader />

      <UiSidebarContent>
        <DashboardSidebarGroup
          v-for="group in groups"
          :key="group.label"
          :items="group.items"
          :label="group.label"
        />
      </UiSidebarContent>

      <UiSidebarRail />

      <DashboardSidebarFooter />
    </UiSidebar>

    <UiSidebarInset class="max-w-full">
      <slot />
    </UiSidebarInset>
  </UiSidebarProvider>
</template>

<style scoped></style>
