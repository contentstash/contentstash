<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";

definePage({ layout: "dashboard" });
</script>

<template>
  <div>
    <slot />
  </div>
</template>
