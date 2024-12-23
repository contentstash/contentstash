<script lang="ts">
export type Props = {
  attributeType: AttributeType;
};
</script>

<script setup lang="ts">
const { attributeType } = defineProps<Props>();
const attribute = defineModel("attribute", {
  type: Object as PropType<ResourceAttribute>,
});

const { generateSchema } = useZodForm();

const formSchema = computed(() => {
  if (!attributeType.formSchema) {
    return;
  }
  return generateSchema({
    schema: attributeType.formSchema,
  });
});
</script>

<template>
  <UiAutoForm
    v-if="formSchema"
    :schema="formSchema.schema"
    :field-config="formSchema.fieldConfig"
  />
</template>
