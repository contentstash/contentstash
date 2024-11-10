<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
import {
  BadgeCheck,
  Bell,
  BookOpen,
  Bug,
  ChevronRight,
  ChevronsUpDown,
  LogOut,
  Settings2,
  FileClock,
  ChartSpline,
  Images,
  Database,
  MessagesSquare,
  ScrollText,
  CodeXml,
  PencilRuler,
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
              <img
                src="/contentstash/logo.png"
                alt="ContentStash"
                class="aspect-square size-8 rounded-lg text-sidebar-primary-foreground"
              />
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
          <UiSidebarGroupLabel>Content</UiSidebarGroupLabel>
          <UiSidebarMenu>
            <UiCollapsible
              v-for="item in navContent"
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

                    <UiTooltipProvider v-if="item.devOnly">
                      <UiTooltip>
                        <UiTooltipTrigger>
                          <CodeXml :size="16" />
                        </UiTooltipTrigger>

                        <UiTooltipContent>
                          <p>Can only be accessed in development mode.</p>
                        </UiTooltipContent>
                      </UiTooltip>
                    </UiTooltipProvider>
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

        <UiSidebarGroup>
          <UiSidebarGroupLabel>System</UiSidebarGroupLabel>
          <UiSidebarMenu>
            <UiCollapsible
              v-for="item in navSystem"
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
