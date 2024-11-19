<script setup lang="ts">
defineSlots<{
  header?(): HTMLElement[];
  title?(): HTMLElement[];
  description?(): HTMLElement[];
  default?(): HTMLElement[];
  trigger?(): HTMLElement;
}>();

const { isDesktop } = useBreakpoints();
const isOpen = ref(false);
</script>

<template>
  <UiDialog v-if="isDesktop" v-model:open="isOpen">
    <UiDialogTrigger as-child>
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
    </UiDialogContent>
  </UiDialog>

  <UiDrawer v-else v-model:open="isOpen">
    <UiDrawerTrigger as-child>
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

      <UiDrawerFooter class="pt-2">
        <DrawerClose as-child>
          <UiButton variant="outline"> Cancel </UiButton>
        </DrawerClose>
      </UiDrawerFooter>
    </UiDrawerContent>
  </UiDrawer>
</template>
