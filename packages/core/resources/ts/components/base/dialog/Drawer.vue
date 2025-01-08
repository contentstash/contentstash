<script setup lang="ts">
defineSlots<{
  header?(): HTMLElement[];
  title?(): HTMLElement[];
  description?(): HTMLElement[];
  default?(): HTMLElement[];
  footer?(): HTMLElement[];
  trigger?(): HTMLElement;
}>();
const open = defineModel("open", { type: Boolean });

const { isDesktop } = useBreakpoints();
</script>

<template>
  <UiDialog v-if="isDesktop" v-model:open="open">
    <UiDialogTrigger v-if="$slots.trigger" as-child>
      <slot name="trigger" />
    </UiDialogTrigger>
    <UiDialogContent class="max-w-2xl">
      <slot
        name="header"
        v-if="$slots.header || $slots.title || $slots.description"
      >
        <UiDialogHeader>
          <UiDialogTitle v-if="$slots.title">
            <slot name="title" />
          </UiDialogTitle>
          <UiDialogDescription v-if="$slots.description">
            <slot name="description" />
          </UiDialogDescription>
        </UiDialogHeader>
      </slot>

      <slot />

      <UiDialogFooter v-if="$slots.footer">
        <slot name="footer" />
      </UiDialogFooter>
    </UiDialogContent>
  </UiDialog>

  <UiDrawer v-else v-model:open="isOpen">
    <UiDrawerTrigger v-if="$slots.trigger" as-child>
      <slot name="trigger" />
    </UiDrawerTrigger>
    <UiDrawerContent>
      <slot
        name="header"
        v-if="$slots.header || $slots.title || $slots.description"
      >
        <UiDrawerHeader>
          <UiDrawerTitle v-if="$slots.title">
            <slot name="title" />
          </UiDrawerTitle>
          <UiDrawerDescription v-if="$slots.description">
            <slot name="description" />
          </UiDrawerDescription>
        </UiDrawerHeader>
      </slot>

      <slot />

      <UiDrawerFooter v-if="$slots.footer">
        <slot name="footer" />
      </UiDrawerFooter>
    </UiDrawerContent>
  </UiDrawer>
</template>
