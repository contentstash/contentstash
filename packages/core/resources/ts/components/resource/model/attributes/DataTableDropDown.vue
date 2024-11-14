<script setup lang="ts">
import { MoreHorizontal } from "lucide-vue-next";

defineProps<{
  attribute: ResourceModelAttribute;
}>();

function copy(id: string) {
  navigator.clipboard.writeText(id);
}
</script>

<template>
  <UiDropdownMenu>
    <UiDropdownMenuTrigger as-child :disabled="attribute.locked">
      <UiButton variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="w-4 h-4" />
      </UiButton>
    </UiDropdownMenuTrigger>
    <UiDropdownMenuContent align="end">
      <UiDropdownMenuLabel>Actions</UiDropdownMenuLabel>
      <UiDropdownMenuItem @click="copy(attribute.name)">
        Copy payment ID
      </UiDropdownMenuItem>
      <UiDropdownMenuSeparator />
      <UiDropdownMenuItem>View customer</UiDropdownMenuItem>
      <UiDropdownMenuItem>View payment details</UiDropdownMenuItem>
    </UiDropdownMenuContent>
  </UiDropdownMenu>
</template>
