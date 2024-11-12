<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

const { disabled = false } = defineProps<{
  to?: Route;
  disabled?: boolean;
}>();
</script>

<template>
  <a v-if="disabled">
    <slot />
  </a>
  <Link v-else-if="to" :href="route(to.name, to.params, to.query)">
    <slot />
  </Link>
  <a v-else>
    <slot />
  </a>
</template>
