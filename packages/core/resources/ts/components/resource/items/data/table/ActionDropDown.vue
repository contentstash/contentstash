<script setup lang="ts">
import type { Row } from "@tanstack/vue-table";
import { MoreHorizontal, Trash2, Pencil } from "lucide-vue-next";

defineProps<{
  meta: TableMeta;
  row: Row<PartialResourceAttribute>;
}>();
</script>

<template>
  <UiDropdownMenu>
    <UiDropdownMenuTrigger as-child>
      <UiButton variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">{{ $t("dropdown.menu.trigger.srOnly") }}</span>
        <MoreHorizontal class="w-4 h-4" />
      </UiButton>
    </UiDropdownMenuTrigger>
    <UiDropdownMenuContent align="end">
      <UiDropdownMenuItem :disabled="true">
        <Pencil />
        {{ $t("action.edit.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem :disabled="true">
        <Trash2 />
        {{ $t("action.delete.label") }}
      </UiDropdownMenuItem>
    </UiDropdownMenuContent>
  </UiDropdownMenu>
</template>
