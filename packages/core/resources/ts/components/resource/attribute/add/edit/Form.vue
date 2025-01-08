<script lang="ts">
export type Props = {
  attributeType: AttributeType;
  defaultValues?: Record<string, unknown>;
};
</script>

<script setup lang="ts">
import type { FormContext } from "vee-validate";

const { attributeType, defaultValues } = defineProps<Props>();
const emit = defineEmits<{
  submit: [{ data: Record<string, unknown> }];
}>();

// form schema
const { generateSchema } = useZodForm();
const formSchema = generateSchema({
  schema: attributeType.formSchema,
});

// form
// eslint-disable-next-line @typescript-eslint/no-explicit-any
const form = useForm<Record<string, any>>({
  ...formSchema.formOptions,
});
if (defaultValues) {
  form.setValues(defaultValues);
}

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const handleSubmit = form.handleSubmit((values: Record<string, any>) => {
  emit("submit", { data: values });
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
}) as unknown as (event?: { [x: string]: any }) => void;

// expose
defineExpose<{
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  form: FormContext<Record<string, any>>;
  handleSubmit: typeof handleSubmit;
  isValid: ComputedRef<boolean>;
}>({
  form,
  handleSubmit,
  isValid: computed(() => form?.meta?.value?.valid ?? false),
});
</script>

<template>
  <div>
    <UiAutoForm
      v-if="form && formSchema"
      :form="form"
      :schema="formSchema.schema"
      :field-config="formSchema.fieldConfig"
      @submit="handleSubmit"
    />
  </div>
</template>
