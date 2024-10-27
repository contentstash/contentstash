<script setup>
import { Head } from "@inertiajs/vue3";

const { getInfo } = useContentStash();
const { getFooBar } = useFoo();
</script>

<template>
  <div>
    <Head title="Test24" />
    <h1>Test2222244443</h1>
    {{ getInfo() }}

    {{ getFooBar() }}
    <UiButton>Test</UiButton>
  </div>
</template>
