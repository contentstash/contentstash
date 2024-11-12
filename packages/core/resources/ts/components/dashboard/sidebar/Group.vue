<script lang="ts">
export type SidebarBaseItem = {
  title: string;
  to?: Route;
  disabled?: boolean;
};
export type SidebarSubItem = SidebarBaseItem;
export type SidebarItem = SidebarBaseItem & {
  icon?: object;
  items?: SidebarSubItem[];
};
</script>

<script setup lang="ts">
import { ChevronRight } from "lucide-vue-next";

defineProps<{
  label?: string;
  items: SidebarItem[];
}>();
</script>

<template>
  <UiSidebarGroup>
    <UiSidebarGroupLabel v-if="label">{{ $t(label) }}</UiSidebarGroupLabel>
    <UiSidebarMenu>
      <UiCollapsible
        v-for="item in items"
        :key="item.title"
        as-child
        class="group/collapsible"
      >
        <!--
          TODO: Add default open state base on route
            - item.isActive doesnt exist and is from the sample data
            - need to implement own logic (e.g. a composable and a attribute for matching routes?)
         :default-open="item.isActive"
         -->
        <UiSidebarMenuItem>
          <UiCollapsibleTrigger as-child>
            <UiSidebarMenuButton :tooltip="item.title">
              <component v-if="item.icon" :is="item.icon" />
              <span>{{ item.title }}</span>
              <ChevronRight
                v-if="item.items"
                class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
              />
            </UiSidebarMenuButton>
          </UiCollapsibleTrigger>
          <UiCollapsibleContent v-if="item.items">
            <UiSidebarMenuSub>
              <UiSidebarMenuSubItem
                v-for="subItem in item.items"
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
                    <span>{{ subItem.title }}</span>
                  </AppLink>
                </UiSidebarMenuSubButton>
              </UiSidebarMenuSubItem>
            </UiSidebarMenuSub>
          </UiCollapsibleContent>
        </UiSidebarMenuItem>
      </UiCollapsible>
    </UiSidebarMenu>
  </UiSidebarGroup>
</template>
