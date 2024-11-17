<script setup lang="ts">
import { Bell, ChevronsUpDown, LogOut, Settings } from "lucide-vue-next";
import useCurentUser from "@/composables/useCurentUser";

const { user } = useCurentUser();
const { getFallbackAvatar } = useUser();
</script>

<template>
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
                <UiAvatarImage :src="user.avatar" :alt="user.full_name" />
                <UiAvatarFallback class="rounded-lg">
                  {{ getFallbackAvatar({ user }) }}
                </UiAvatarFallback>
              </UiAvatar>
              <div class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-semibold">{{ user.full_name }}</span>
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
                  <UiAvatarImage :src="user.avatar" :alt="user.full_name" />
                  <UiAvatarFallback class="rounded-lg">
                    {{ getFallbackAvatar({ user }) }}
                  </UiAvatarFallback>
                </UiAvatar>
                <div class="grid flex-1 text-left text-sm leading-tight">
                  <span class="truncate font-semibold">
                    {{ user.full_name }}
                  </span>
                  <span class="truncate text-xs">{{ user.email }}</span>
                </div>
              </div>
            </UiDropdownMenuLabel>
            <UiDropdownMenuSeparator />
            <UiDropdownMenuGroup>
              <UiDropdownMenuItem :disabled="true">
                <Settings />
                {{ $t("page.user.settings.title") }}
              </UiDropdownMenuItem>
              <UiDropdownMenuItem :disabled="true">
                <Bell />
                {{ $t("page.user.notifications.title") }}
              </UiDropdownMenuItem>
            </UiDropdownMenuGroup>
            <UiDropdownMenuSeparator />
            <UiDropdownMenuItem :disabled="true">
              <LogOut />
              {{ $t("user.action.logOut.label") }}
            </UiDropdownMenuItem>
          </UiDropdownMenuContent>
        </UiDropdownMenu>
      </UiSidebarMenuItem>
    </UiSidebarMenu>
  </UiSidebarFooter>
</template>
