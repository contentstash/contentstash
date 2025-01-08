<script setup lang="ts">
import { getCurrentInstance } from "vue";
import { Clipboard, ClipboardCheck } from "lucide-vue-next";

const { title = "Untitled object" } = defineProps<{
  title?: string;
}>();
const model = defineModel();

const { uid } = getCurrentInstance()!;

const copyToClipboardTimeout = ref<NodeJs.Timeout | null>(null);
const copySuccess = ref(false);
const copyToClipboard = (event: Event) => {
  event.stopPropagation();
  navigator.clipboard.writeText(JSON.stringify(model.value, null, 2));
  copySuccess.value = true;
  copyToClipboardTimeout.value = setTimeout(() => {
    copySuccess.value = false;
  }, 1000);
};
onUnmounted(() => {
  if (copyToClipboardTimeout.value) {
    clearTimeout(copyToClipboardTimeout.value);
  }
});
</script>

<template>
  <div class="flex w-full items-top gap-8">
    <UiAccordionItem :value="uid.toString()" class="grow">
      <UiAccordionTrigger class=" ">
        <span>{{ title }}</span>
      </UiAccordionTrigger>
      <UiAccordionContent>
        <pre
          class="bg-gray-50 dark:bg-black px-4 pt-4 pb-6 overflow-x-auto rounded-xl"
          >{{ model }}</pre
        >
      </UiAccordionContent>
    </UiAccordionItem>

    <div class="pt-2.5">
      <UiButton @click="copyToClipboard" size="sm" :disabled="copySuccess">
        <ClipboardCheck v-if="copySuccess" />
        <Clipboard v-else />
      </UiButton>
    </div>
  </div>
</template>
