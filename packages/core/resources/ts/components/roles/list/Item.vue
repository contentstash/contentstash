<script setup lang="ts">
defineProps<{
  role: Role;
}>();
</script>

<template>
  <UiCard>
    <AppLink :to="{ name: 'dashboard.roles.edit', params: { id: role.id } }">
      <UiCardContent class="pt-4 pb-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            {{ role.name }}
            <UiBadge v-if="role.is_system" variant="destructive">
              {{ $t("role.is_system.label") }}
            </UiBadge>
          </div>
          <span>{{ $t("page.dashboard.roles.id.edit.title") }}</span>
        </div>
      </UiCardContent>
    </AppLink>
  </UiCard>
</template>
