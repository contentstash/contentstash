<script setup lang="ts">
import { Head } from "@inertiajs/vue3";

usePage({ layout: "default" });
import {
  EnvelopeOpenIcon,
  ReloadIcon,
  ExclamationTriangleIcon,
} from "@radix-icons/vue";
// import { Button } from "@/components/ui/button";
// import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
</script>

<template>
  <div>
    <Head title="Admin Index" />
    <h1 class="text-red-500 font-bold">Admin Index</h1>

    <UiButton variant="outline">Click me</UiButton>

    <UiAlert variant="destructive">
      <ExclamationTriangleIcon class="w-4 h-4" />
      <UiAlertTitle>Heads up!</UiAlertTitle>
      <UiAlertDescription>
        You can add components to your app using the cli.
      </UiAlertDescription>
    </UiAlert>

    <UiButton>
      <EnvelopeOpenIcon class="w-4 h-4 mr-2" /> Login with Email
    </UiButton>

    <UiButton disabled>
      <ReloadIcon class="w-4 h-4 mr-2 animate-spin" />
      Please wait
    </UiButton>
  </div>
</template>
