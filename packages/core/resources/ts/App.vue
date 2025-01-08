<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
// import { SUPPORTED_LOCALES, getLocaleMessages } from "@/i18n";
useColorMode();

// const { locale, availableLocales, setLocaleMessage } = useI18n();
// const activeLocale = ref(toRaw(locale.value));

// watch(activeLocale, async () => {
//   const messages = await getLocaleMessages({
//     locale: activeLocale.value,
//   });

//   setLocaleMessage(activeLocale.value, messages);

//   locale.value = activeLocale.value;
// });
</script>

<template>
  <div>
    <!-- <UiSelect v-model="activeLocale">
      <UiSelectTrigger>
        <UiSelectValue placeholder="Select a language" />
      </UiSelectTrigger>
      <UiSelectContent>
        <UiSelectGroup>
          <UiSelectItem v-for="l in SUPPORTED_LOCALES" :key="l" :value="l">
            {{ l }}
          </UiSelectItem>
        </UiSelectGroup>
      </UiSelectContent>
    </UiSelect>
    {{ availableLocales }}
    {{ locale }} -->
    <slot />
  </div>
</template>
