<script lang="ts">
export type Props = {
  attributeType: AttributeType;
};
</script>

<script setup lang="ts">
import { toTypedSchema } from "@vee-validate/zod";

const { attributeType } = defineProps<Props>();
const form = defineModel("form", {
  type: Object as PropType<ReturnType<typeof useForm>>,
});
const emit = defineEmits<{
  submit: [{ data: Record<string, unknown> }];
}>();

// form schema
const { generateSchema } = useZodForm();
const formSchema = attributeType.formSchema
  ? generateSchema({
      schema: attributeType.formSchema,
    })
  : undefined;

// form
if (formSchema) {
  const temp = useForm({
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    validationSchema: toTypedSchema(formSchema.schema as unknown as any),
  });

  // temp.handleSubmit = (data: Record<string, unknown>) => {
  //   emit("submit", { data });
  // };

  const onSubmit = temp.handleSubmit((data: Record<string, unknown>) => {
    console.info("onSubmit", data);
  });

  console.info("temp", temp);

  form.value = temp;
}
</script>

<template>
  {{ form }}
  <div>
    <UiAutoForm
      v-if="form && formSchema"
      :form="form"
      :schema="formSchema.schema"
      :field-config="formSchema.fieldConfig"
      @submit="test"
    />
  </div>
</template>
