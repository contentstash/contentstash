<script setup lang="ts">
import type { SidebarGroup } from "@/components/dashboard/sidebar/Group.vue";
import { useColorMode } from "@vueuse/core";
import {
  BookOpen,
  Bug,
  ChartSpline,
  Database,
  FileClock,
  Images,
  MessagesSquare,
  PencilRuler,
  ScrollText,
  Settings2,
  Shield,
  Users,
} from "lucide-vue-next";

useColorMode();

const navGroups: SidebarGroup[] = [
  {
    label: "dashboard.sidebar.content.label",
    items: [
      {
        title: "dashboard.sidebar.content.item.resources.label",
        icon: Database,
        items: [
          {
            title: "Comments",
            to: {
              name: "dashboard.index",
            },
          },
          {
            title: "Posts",
            to: {
              name: "dashboard.test.index",
            },
          },
          {
            title: "Users",
            disabled: true,
          },
        ],
      },
      {
        title: "dashboard.sidebar.content.item.media.label",
        icon: Images,
        disabled: true,
      },
      {
        title: "dashboard.sidebar.content.item.resourceBuilder.label",
        icon: PencilRuler,
        items: [
          [
            {
              title: "Add new Resource",
              disabled: true,
            },
          ],
          [
            {
              title: "Comments",
              disabled: true,
            },
            {
              title: "Posts",
              disabled: true,
            },
            {
              title: "Users",
              disabled: true,
            },
          ],
        ],
      },
    ],
  },
  {
    label: "dashboard.sidebar.system.label",
    items: [
      {
        title: "dashboard.sidebar.system.item.auditLog.label",
        icon: FileClock,
        disabled: true,
      },
      {
        title: "dashboard.sidebar.system.item.monitoring.label",
        icon: ChartSpline,
        disabled: true,
      },
      {
        title: "dashboard.sidebar.system.item.users.label",
        icon: Users,
        disabled: true,
      },
      {
        title: "dashboard.sidebar.system.item.roles.label",
        icon: Shield,
        disabled: true,
      },
      {
        title: "dashboard.sidebar.system.item.settings.label",
        icon: Settings2,
        items: [
          {
            title: "dashboard.sidebar.system.item.settings.item.general.label",
            disabled: true,
          },
          {
            title: "dashboard.sidebar.system.item.settings.item.auditLog.label",
            disabled: true,
          },
          {
            title:
              "dashboard.sidebar.system.item.settings.item.monitoring.label",
            disabled: true,
          },
          {
            title: "dashboard.sidebar.system.item.settings.item.media.label",
            disabled: true,
          },
          {
            title: "dashboard.sidebar.system.item.settings.item.plugins.label",
            disabled: true,
          },
        ],
      },
    ],
  },
  {
    label: "dashboard.sidebar.contentStash.label",
    items: [
      {
        title: "dashboard.sidebar.contentStash.item.bugs.label",
        icon: Bug,
        to: "https://github.com/contentstash/contentstash/issues",
      },
      {
        title: "dashboard.sidebar.contentStash.item.changelog.label",
        icon: ScrollText,
        to: "https://github.com/contentstash/contentstash/releases",
      },
      {
        title: "dashboard.sidebar.contentStash.item.community.label",
        icon: MessagesSquare,
        to: "https://github.com/contentstash/contentstash/discussions",
      },
      {
        title: "dashboard.sidebar.contentStash.item.documentation.label",
        icon: BookOpen,
        disabled: true,
      },
    ],
  },
];
</script>

<template>
  <DashboardSidebar :groups="navGroups">
    <header
      class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12"
    >
      <div class="flex items-center gap-2 px-4">
        <UiSidebarTrigger class="-ml-1" />
        <UiSeparator orientation="vertical" class="mr-2 h-4" />
        <AppBreadcrumbs />
      </div>
    </header>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <slot />
    </div>
  </DashboardSidebar>
</template>
