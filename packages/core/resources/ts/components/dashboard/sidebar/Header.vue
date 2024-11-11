<script setup lang="ts">
const { getInfo } = useContentStash();
</script>

<template>
  <UiSidebarHeader>
    <UiSidebarMenu>
      <UiSidebarMenuItem>
        <UiSidebarMenuButton size="lg">
          <img
            src="/contentstash/logo.png"
            alt="ContentStash"
            class="aspect-square size-8 rounded-lg text-sidebar-primary-foreground"
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
