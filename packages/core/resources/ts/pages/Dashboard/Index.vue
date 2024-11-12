<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <Head title="Admin Index" />

  <div>
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
      <div class="aspect-video rounded-xl bg-muted/50" />
      <div class="aspect-video rounded-xl bg-muted/50" />
      <div class="aspect-video rounded-xl bg-muted/50" />
    </div>
    <div class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min" />
    <AppLink :to="{ name: 'dashboard.test.index' }">Dashboard/Test</AppLink>

    {{ $t("foo.bar") }}
  </div>
</template>
