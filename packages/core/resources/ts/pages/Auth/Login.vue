<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { toTypedSchema } from "@vee-validate/zod";
import { z } from "zod";

const { errors } = defineProps<{
  errors: Record<string, string>;
}>();

// form
const { t } = useI18n();
const formSchema = z.object({
  email: z.string().email(),
  password: z.string(),
});
const formFieldConfig = {
  email: {
    label: t("auth.email.label"),
    inputProps: {
      type: "email",
      placeholder: t("auth.email.placeholder"),
    },
  },
  password: {
    label: t("auth.password.label"),
    inputProps: {
      type: "password",
      placeholder: t("auth.password.placeholder"),
    },
  },
};
const form = useForm({
  validationSchema: toTypedSchema(formSchema),
});
const loginButtonIsDisabled = computed(() => {
  return !form.meta.value?.valid;
});
const authenticateRoute = useRoute("auth.authenticate");
const handleLogin = async () => {
  useRouter().post(authenticateRoute, {
    ...form.values,
  });
};
</script>

<template>
  <Head :title="$t('page.auth.login.meta.title')" />
  <UiCard>
    <UiCardHeader>
      <UiCardTitle class="text-2xl">
        {{ $t("page.auth.login.header.title") }}
      </UiCardTitle>
      <UiCardDescription>
        {{ $t("page.auth.login.header.description") }}
      </UiCardDescription>
    </UiCardHeader>
    <UiCardContent class="grid gap-4">
      <AppAlert v-for="(error, index) in errors" :key="index" type="error">
        <template v-if="error" #description>
          {{ error }}
        </template>
      </AppAlert>

      <UiAutoForm
        :form="form"
        :schema="formSchema"
        :fieldConfig="formFieldConfig"
      />
    </UiCardContent>
    <UiCardFooter>
      <UiButton
        class="w-full"
        @click="handleLogin"
        :disabled="loginButtonIsDisabled"
      >
        {{ $t("action.login.label") }}
      </UiButton>
    </UiCardFooter>
  </UiCard>
</template>
