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
  <div>
    <!-- TODO -->
  </div>
</template>

<style scoped></style>
