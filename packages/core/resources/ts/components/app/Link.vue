<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

const { disabled = false, to } = defineProps<{
  to?: Route | string;
  disabled?: boolean;
}>();

const href = computed(() => {
  if (typeof to === "string") {
    return to;
  } else if (to) {
    return useRoute(to.name, to.params, to.query);
  }
  return undefined;
});

const isExternal = computed(() => {
  return typeof to === "string" && to.startsWith("http");
});
</script>

<template>
  <a v-if="disabled">
    <slot />
  </a>
  <Link v-else-if="to && !isExternal" :href="href">
    <slot />
  </Link>
  <a
    v-else-if="to"
    :href="to"
    :target="isExternal ? '_blank' : undefined"
    :rel="isExternal ? 'noopener noreferrer' : undefined"
  >
    <slot />
  </a>
  <template v-else>
    <slot />
  </template>
</template>
