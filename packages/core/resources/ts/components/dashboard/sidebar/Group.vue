<script lang="ts">
export type SidebarBaseItem = {
  title: string;
  to?: Route;
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
    <UiSidebarGroupLabel v-if="label">{{ label }}</UiSidebarGroupLabel>
    <UiSidebarMenu>
      <UiCollapsible
        v-for="item in items"
        :key="item.title"
        as-child
        class="group/collapsible"
      >
        <!--        :default-open="item.isActive"-->
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
                <UiSidebarMenuSubButton as-child>
                  <!--                  <a :href="subItem.url">-->
                  <span>{{ subItem.title }}</span>
                  <!--                  </a>-->
                </UiSidebarMenuSubButton>
              </UiSidebarMenuSubItem>
            </UiSidebarMenuSub>
          </UiCollapsibleContent>
        </UiSidebarMenuItem>
      </UiCollapsible>
    </UiSidebarMenu>
  </UiSidebarGroup>
</template>
