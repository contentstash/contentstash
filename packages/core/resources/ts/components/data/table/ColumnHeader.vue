<script lang="ts">
export default {
  inheritAttrs: false,
};
</script>

<script setup lang="ts">
import type { Column } from "@tanstack/vue-table";
// import { type Task } from '../data/schema'

import {
  ChevronDown,
  ChevronUp,
  ChevronsUpDown,
  EyeClosed,
} from "lucide-vue-next";

import { cn } from "@/lib/utils";

interface DataTableColumnHeaderProps {
  // TODO: Check if better type can be used
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  column: Column<any, any>;
  title: string;
}

defineProps<DataTableColumnHeaderProps>();
</script>

<template>
  <div
    v-if="column.getCanSort()"
    :class="cn('flex items-center space-x-2', $attrs.class ?? '')"
  >
    <UiButton
      variant="ghost"
      size="sm"
      class="-ml-3 h-8 data-[state=open]:bg-accent"
      @click="column.toggleSorting()"
    >
      <span>{{ title }}</span>
      <ChevronDown
        v-if="column.getIsSorted() === 'desc'"
        class="w-4 h-4 ml-2"
      />
      <ChevronUp
        v-else-if="column.getIsSorted() === 'asc'"
        class="w-4 h-4 ml-2"
      />
      <ChevronsUpDown v-else class="w-4 h-4 ml-2" />
    </UiButton>
  </div>

  <div v-else :class="$attrs.class">
    {{ title }}
  </div>
</template>
