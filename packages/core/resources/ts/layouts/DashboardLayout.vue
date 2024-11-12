<script setup lang="ts">
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
} from "lucide-vue-next";

useColorMode();

const navGroups = [
  {
    label: "dashboard.sidebar.content.label",
    items: [
      {
        title: "Resources",
        url: "#",
        icon: Database,
        isActive: true,
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
              name: "dashboard.index2",
            },
          },
          {
            title: "Users",
            disabled: true,
          },
        ],
      },
      {
        title: "Media Library",
        url: "#",
        icon: Images,
      },
      {
        title: "Resource-Builder",
        url: "#",
        icon: PencilRuler,
        devOnly: true,
        items: [
          {
            title: "Add new Resource",
            url: "#",
          },
          {
            title: "Comments",
            url: "#",
          },
          {
            title: "Posts",
            url: "#",
          },
          {
            title: "Users",
            url: "#",
          },
        ],
      },
    ],
  },
  {
    label: "dashboard.sidebar.system.label",
    items: [
      {
        title: "Audit-Log",
        url: "#",
        icon: FileClock,
      },
      {
        title: "Monitoring",
        url: "#",
        icon: ChartSpline,
      },
      {
        title: "Settings",
        url: "#",
        icon: Settings2,
        items: [
          {
            title: "General",
            url: "#",
          },
          {
            title: "Audit-Log",
            url: "#",
          },
          {
            title: "Monitoring",
            url: "#",
          },
          {
            title: "Media Library",
            url: "#",
          },
          {
            title: "Plugins",
            url: "#",
          },
        ],
      },
    ],
  },
  {
    label: "dashboard.sidebar.contentStash.label",
    items: [
      {
        title: "Bugs",
        url: "#",
        icon: Bug,
      },
      {
        title: "Changelog",
        url: "#",
        icon: ScrollText,
      },
      {
        title: "Community",
        url: "#",
        icon: MessagesSquare,
      },
      {
        title: "Documentation",
        url: "#",
        icon: BookOpen,
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
        <UiBreadcrumb>
          <UiBreadcrumbList>
            <UiBreadcrumbItem class="hidden md:block">
              <UiBreadcrumbLink href="#"> Dashboard </UiBreadcrumbLink>
            </UiBreadcrumbItem>
            <UiBreadcrumbSeparator class="hidden md:block" />
            <UiBreadcrumbItem>
              <UiBreadcrumbPage>Index</UiBreadcrumbPage>
            </UiBreadcrumbItem>
          </UiBreadcrumbList>
        </UiBreadcrumb>
      </div>
    </header>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <slot />
    </div>
  </DashboardSidebar>
</template>
