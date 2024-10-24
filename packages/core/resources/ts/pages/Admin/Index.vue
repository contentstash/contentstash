<script setup lang="ts">
import { Head } from "@inertiajs/vue3";

import {
  EnvelopeOpenIcon,
  ReloadIcon,
  ExclamationTriangleIcon,
} from "@radix-icons/vue";
import { Button } from "@/components/ui/button";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";

import { useColorMode } from "@vueuse/core";

useColorMode();
</script>

<template>
  <div>
    <Head title="Admin Index" />
    <h1 class="text-red-500 font-bold">Admin Index</h1>

    <Button variant="outline">Click me</Button>

    <Alert variant="destructive">
      <ExclamationTriangleIcon class="w-4 h-4" />
      <AlertTitle>Heads up!</AlertTitle>
      <AlertDescription>
        You can add components to your app using the cli.
      </AlertDescription>
    </Alert>

    <Button>
      <EnvelopeOpenIcon class="w-4 h-4 mr-2" /> Login with Email
    </Button>

    <Button disabled>
      <ReloadIcon class="w-4 h-4 mr-2 animate-spin" />
      Please wait
    </Button>
  </div>
</template>
