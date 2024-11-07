<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
import {
  // AudioWaveform,
  BadgeCheck,
  Bell,
  BookOpen,
  // Bot,
  Bug,
  ChevronRight,
  ChevronsUpDown,
  // Command,
  // CreditCard,
  // Folder,
  // Forward,
  // Frame,
  // GalleryVerticalEnd,
  LogOut,
  // Map,
  // MoreHorizontal,
  // PieChart,
  // Plus,
  Settings2,
  Sparkles,
  // SquareTerminal,
  // Trash2,
  Database,
  Boxes,
  MessagesSquare,
  ScrollText,
} from "lucide-vue-next";
import useContentStash from "@/composables/useContentStash";

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
const navMain = [
  {
    title: "Content",
    url: "#",
    icon: Boxes,
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
    title: "Resource-Builder",
    url: "#",
    icon: Database,
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
    title: "Settings",
    url: "#",
    icon: Settings2,
    items: [
      {
        title: "General",
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
    name: "Bugs",
    url: "#",
    icon: Bug,
  },
  {
    name: "Changelog",
    url: "#",
    icon: ScrollText,
  },
  {
    name: "Community",
    url: "#",
    icon: MessagesSquare,
  },
  {
    name: "Documentation",
    url: "#",
    icon: BookOpen,
  },
];

const { getInfo } = useContentStash();
</script>

<template>
  <UiSidebarProvider>
    <UiSidebar collapsible="icon">
      <UiSidebarHeader>
        <UiSidebarMenu>
          <UiSidebarMenuItem>
            <UiSidebarMenuButton size="lg">
              <div
                class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground"
              >
                <component :is="Sparkles" class="size-4" />
              </div>
              <div class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-semibold">{{
                  getInfo().app.name
                }}</span>
                <span class="truncate text-xs"
                  >Version: {{ getInfo().core.version }}</span
                >
              </div>
            </UiSidebarMenuButton>
          </UiSidebarMenuItem>
        </UiSidebarMenu>
      </UiSidebarHeader>

      <UiSidebarContent>
        <UiSidebarGroup>
          <UiSidebarGroupLabel>Application</UiSidebarGroupLabel>
          <UiSidebarMenu>
            <UiCollapsible
              v-for="item in navMain"
              :key="item.title"
              as-child
              :default-open="item.isActive"
              class="group/collapsible"
            >
              <UiSidebarMenuItem>
                <UiCollapsibleTrigger as-child>
                  <UiSidebarMenuButton :tooltip="item.title">
                    <component :is="item.icon" />
                    <span>{{ item.title }}</span>
                    <ChevronRight
                      class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                    />
                  </UiSidebarMenuButton>
                </UiCollapsibleTrigger>
                <UiCollapsibleContent>
                  <UiSidebarMenuSub>
                    <UiSidebarMenuSubItem
                      v-for="subItem in item.items"
                      :key="subItem.title"
                    >
                      <UiSidebarMenuSubButton as-child>
                        <a :href="subItem.url">
                          <span>{{ subItem.title }}</span>
                        </a>
                      </UiSidebarMenuSubButton>
                    </UiSidebarMenuSubItem>
                  </UiSidebarMenuSub>
                </UiCollapsibleContent>
              </UiSidebarMenuItem>
            </UiCollapsible>
          </UiSidebarMenu>
        </UiSidebarGroup>

        <UiSidebarGroup class="group-data-[collapsible=icon]:hidden">
          <UiSidebarGroupLabel>ContentStash</UiSidebarGroupLabel>
          <UiSidebarMenu>
            <UiSidebarMenuItem v-for="item in navContenstash" :key="item.name">
              <UiSidebarMenuButton as-child>
                <a :href="item.url">
                  <component :is="item.icon" />
                  <span>{{ item.name }}</span>
                </a>
              </UiSidebarMenuButton>
            </UiSidebarMenuItem>
          </UiSidebarMenu>
        </UiSidebarGroup>
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
