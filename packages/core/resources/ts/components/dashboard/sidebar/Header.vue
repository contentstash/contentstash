<script setup lang="ts">
import AppLink from "@/components/app/Link.vue";

const { getInfo } = useContentStash();
</script>

<template>
  <UiSidebarHeader>
    <UiSidebarMenu>
      <UiSidebarMenuItem>
        <UiSidebarMenuButton
          size="lg"
          :as="AppLink"
          :to="{
            name: 'dashboard.index',
          }"
        >
          <img
            src="/contentstash/logo.png"
            alt="ContentStash"
            class="aspect-square size-8 text-sidebar-primary-foreground rounded-md"
          />
          <div class="grid flex-1 text-left text-sm leading-tight">
            <span class="truncate font-semibold">
              {{ getInfo().app.name }}
            </span>
            <span class="truncate text-xs">
              Version: {{ getInfo().core.version }}
            </span>
          </div>
        </UiSidebarMenuButton>
      </UiSidebarMenuItem>
    </UiSidebarMenu>
  </UiSidebarHeader>
</template>
