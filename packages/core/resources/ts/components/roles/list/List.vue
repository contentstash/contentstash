<script setup lang="ts">
defineProps<{
  roles: Role[];
}>();
</script>

<template>
  <div class="flex flex-col gap-4">
    <RolesListItem v-for="role in roles" :role="role" :key="role.id" />
  </div>
</template>
