<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
import {
  BadgeCheck,
  Bell,
  BookOpen,
  Bug,
  ChevronsUpDown,
  LogOut,
  Settings2,
  FileClock,
  ChartSpline,
  Images,
  Database,
  MessagesSquare,
  ScrollText,
  PencilRuler,
} from "lucide-vue-next";

useColorMode();

const user = {
  name: "TitusKirch",
  email: "contact@kirch.dev",
  avatar: "https://avatars.githubusercontent.com/u/16943133?v=4",
};
const avatarFallback = (name: string) => {
  const upperCaseLetters = name.match(/[A-Z]/g) || [];
  return upperCaseLetters.slice(0, 3).join("");
};

// This is sample data.
const navContent = [
  {
    title: "Resources",
    url: "#",
    icon: Database,
    isActive: true,
    items: [
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
];

const navSystem = [
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
];

const navContenstash = [
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
];
</script>

<template>
  <UiSidebarProvider>
    <UiSidebar collapsible="icon">
      <DashboardSidebarHeader />

      <UiSidebarContent>
        <DashboardSidebarGroup
          :items="navContent"
          :label="$t('core.dashboard.sidebar.content.label')"
        />
        <DashboardSidebarGroup
          :items="navSystem"
          :label="$t('dashboard.sidebar.system.label')"
        />
        <DashboardSidebarGroup
          :items="navContenstash"
          :label="$t('dashboard.sidebar.contentStash.label')"
        />
      </UiSidebarContent>

      <UiSidebarFooter>
        <UiSidebarMenu>
          <UiSidebarMenuItem>
            <UiDropdownMenu>
              <UiDropdownMenuTrigger as-child>
                <UiSidebarMenuButton
                  size="lg"
                  class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                >
                  <UiAvatar class="h-8 w-8 rounded-lg">
                    <UiAvatarImage :src="user.avatar" :alt="user.name" />
                    <UiAvatarFallback class="rounded-lg">{{
                      avatarFallback(user.name)
                    }}</UiAvatarFallback>
                  </UiAvatar>
                  <div class="grid flex-1 text-left text-sm leading-tight">
                    <span class="truncate font-semibold">{{ user.name }}</span>
                    <span class="truncate text-xs">{{ user.email }}</span>
                  </div>
                  <ChevronsUpDown class="ml-auto size-4" />
                </UiSidebarMenuButton>
              </UiDropdownMenuTrigger>
              <UiDropdownMenuContent
                class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                side="bottom"
                align="end"
                :side-offset="4"
              >
                <UiDropdownMenuLabel class="p-0 font-normal">
                  <div
                    class="flex items-center gap-2 px-1 py-1.5 text-left text-sm"
                  >
                    <UiAvatar class="h-8 w-8 rounded-lg">
                      <UiAvatarImage :src="user.avatar" :alt="user.name" />
                      <UiAvatarFallback class="rounded-lg">
                        {{ avatarFallback(user.name) }}
                      </UiAvatarFallback>
                    </UiAvatar>
                    <div class="grid flex-1 text-left text-sm leading-tight">
                      <span class="truncate font-semibold">{{
                        user.name
                      }}</span>
                      <span class="truncate text-xs">{{ user.email }}</span>
                    </div>
                  </div>
                </UiDropdownMenuLabel>
                <UiDropdownMenuSeparator />
                <UiDropdownMenuGroup>
                  <UiDropdownMenuItem>
                    <BadgeCheck />
                    Account
                  </UiDropdownMenuItem>
                  <UiDropdownMenuItem>
                    <Bell />
                    Notifications
                  </UiDropdownMenuItem>
                </UiDropdownMenuGroup>
                <UiDropdownMenuSeparator />
                <UiDropdownMenuItem>
                  <LogOut />
                  Log out
                </UiDropdownMenuItem>
              </UiDropdownMenuContent>
            </UiDropdownMenu>
          </UiSidebarMenuItem>
        </UiSidebarMenu>
      </UiSidebarFooter>

      <UiSidebarRail />
    </UiSidebar>

    <UiSidebarInset>
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
    </UiSidebarInset>
  </UiSidebarProvider>
</template>
