<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

const {
  disabled = false,
  to,
  variant = "ghost",
} = defineProps<{
  to?: Route | string;
  disabled?: boolean;
  variant?: "underline" | "ghost";
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

const classes = computed(() => {
  return {
    underline: variant === "underline",
  };
});
</script>

<template>
  <a v-if="disabled" :class="classes">
    <slot />
  </a>
  <Link v-else-if="to && !isExternal" :href="href" :class="classes">
    <slot />
  </Link>
  <a
    v-else-if="to"
    :href="to"
    :target="isExternal ? '_blank' : undefined"
    :rel="isExternal ? 'noopener noreferrer' : undefined"
    :class="classes"
  >
    <slot />
  </a>
  <div v-else :class="classes">
    <slot />
  </div>
</template>
