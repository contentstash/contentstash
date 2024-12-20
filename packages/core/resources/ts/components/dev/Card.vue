<script setup lang="ts">
const isDev = import.meta.env.DEV;
</script>

<template>
  <UiCard v-if="isDev">
    <UiCardHeader>
      <UiCardTitle>
        {{ $t("dev.card.title") }}
      </UiCardTitle>
      <UiCardDescription>
        {{ $t("dev.card.description") }}
      </UiCardDescription>
    </UiCardHeader>

    <UiCardContent>
      <UiAccordion type="multiple" collapsible>
        <slot />
      </UiAccordion>
    </UiCardContent>
  </UiCard>
</template>
