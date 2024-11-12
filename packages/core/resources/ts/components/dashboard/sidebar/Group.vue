<script lang="ts">
export type SidebarBaseItem = {
  title: string;
  to?: Route | string;
  disabled?: boolean;
};
export type SidebarSubItem = SidebarBaseItem;
export type SidebarItem = SidebarBaseItem & {
  icon?: object;
  items?: SidebarSubItem[] | SidebarSubItem[][];
};
export type SidebarGroup = {
  label?: string;
  items: SidebarItem[];
};
</script>

<script setup lang="ts">
import { ChevronRight, Plus } from "lucide-vue-next";

defineProps<SidebarGroup>();

const checkIfSubItemIsActive = ({ item }: { item: SidebarItem }) => {
  return (
    Array.isArray(item.items) &&
    item.items.some(
      (subItem) => subItem.to?.name && useRoute().current(subItem.to.name),
    )
  );
};

const { isI18nString } = useI18nString();
</script>

<template>
  <UiSidebarGroup>
    <UiSidebarGroupLabel v-if="label">{{
      isI18nString(label) ? $t(label) : label
    }}</UiSidebarGroupLabel>
    <UiSidebarMenu>
      <UiCollapsible
        v-for="item in items"
        :key="item.title"
        as-child
        class="group/collapsible"
        :default-open="checkIfSubItemIsActive({ item })"
      >
        <UiSidebarMenuItem>
          <UiCollapsibleTrigger as-child>
            <UiSidebarMenuButton
              :tooltip="isI18nString(item.title) ? $t(item.title) : item.title"
              :as-child="!!item.to || !item?.items"
              :class="{
                'text-muted-foreground hover:text-muted-foreground hover:cursor-not-allowed':
                  item.disabled,
              }"
            >
              <AppLink :to="item.to" :disabled="item.disabled">
                <component v-if="item.icon" :is="item.icon" />
                <span>{{
                  isI18nString(item.title) ? $t(item.title) : item.title
                }}</span>
                <ChevronRight
                  v-if="item.items"
                  class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                />
              </AppLink>
            </UiSidebarMenuButton>
          </UiCollapsibleTrigger>
          <UiCollapsibleContent v-if="item.items">
            <UiSidebarMenuSub>
              <template v-if="Array.isArray(item.items[0])">
                <template
                  v-for="(subItems, index) in item.items as SidebarBaseItem[][]"
                  :key="index"
                >
                  <DashboardSidebarGroupSubItem :items="subItems" />
                  <UiSidebarSeparator v-if="index < item.items.length - 1" />
                </template>
              </template>
              <DashboardSidebarGroupSubItem
                v-else
                :items="item.items as SidebarBaseItem[]"
              />
            </UiSidebarMenuSub>
          </UiCollapsibleContent>
        </UiSidebarMenuItem>
      </UiCollapsible>
    </UiSidebarMenu>
  </UiSidebarGroup>
</template>
