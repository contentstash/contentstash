<script setup lang="ts">
defineSlots<{
  description?: HTMLElement[];
  header?: HTMLElement[];
  headerActions?: HTMLElement[];
  title?: HTMLElement[];
}>();
</script>

<template>
  <div class="flex justify-between w-full">
    <div
      v-if="$slots.header || $slots.title || $slots.description"
      class="flex flex-col gap-y-1.5 mb-6 px-2"
    >
      <slot name="header">
        <h2
          v-if="$slots.title"
          class="scroll-m-20 text-3xl font-semibold tracking-tight first:mt-0"
        >
          <slot name="title" />
        </h2>
        <p v-if="$slots.description" class="text-sm text-muted-foreground">
          <slot name="description" />
        </p>
      </slot>
    </div>
    <div v-else />
    <div class="p-6 flex items-center gap-2">
      <slot name="headerActions" />
    </div>
  </div>
</template>
