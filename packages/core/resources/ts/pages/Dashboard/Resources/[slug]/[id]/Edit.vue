<script setup lang="ts">
const {
  props: { id, item, slug, model, modelInfo },
}: {
  props: {
    id: string;
    // TODO: Add type
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    item: any;
    slug: string;
    model: Resource;
    modelInfo: ResourceInfo;
  };
} = usePage();

const title = computed(() => {
  return model.split("\\").pop();
});

// general form
const entryFormSchema = computed<FormSchema>(() => {
  return modelInfo.attributes
    .filter(
      (attribute) =>
        !["id", "created_at", "updated_at", "deleted_at"].includes(
          attribute.name,
        ),
    )
    .reduce((schema, attribute) => {
      schema[attribute.name] = {
        label: attribute.name,
        required: !attribute.nullable,
        ...attribute.attributeType.entryFormSchema,
      };
      return schema;
    }, {});
});
const { generateSchema } = useZodForm();
const generalFormSchema = generateSchema({
  schema: entryFormSchema.value,
});
const generalForm = useForm({
  ...generalFormSchema.formOptions,
});
generalForm.setValues(item);

// update
const updateButtonIsDisabled = computed(() => {
  return !generalForm.meta.value?.valid;
});
const updateRoute = useRoute("dashboard.resources.slug.id.update", {
  slug,
  id,
});
const updateHandler = () => {
  useRouter().put(updateRoute, {
    // TODO: Add type
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    data: generalForm.values as any,
  });
};
</script>

<template>
  <DashboardPage
    :title="
      $t('page.dashboard.resources.id.edit.meta.title', {
        modelTitle: title,
      })
    "
  >
    <DashboardPageHeader>
      <template #title>
        {{
          $t("page.dashboard.resources.slug.id.edit.header.title", {
            modelTitle: title,
          })
        }}
      </template>
      <template #description>
        {{ $t("page.dashboard.resources.slug.id.edit.header.description") }}
      </template>
    </DashboardPageHeader>

    <UiCard>
      <UiCardHeader>
        <UiCardTitle>
          {{ $t("page.dashboard.resources.slug.id.edit.general.title") }}
        </UiCardTitle>
        <UiCardDescription>
          {{ $t("page.dashboard.resources.slug.id.edit.general.description") }}
        </UiCardDescription>
      </UiCardHeader>
      <UiCardContent>
        <UiAutoForm
          :form="generalForm"
          :schema="generalFormSchema.schema"
          :field-config="generalFormSchema.fieldConfig"
        />
      </UiCardContent>
    </UiCard>

    <div class="flex justify-end gap-2">
      <UiButton @click="updateHandler()" :disabled="updateButtonIsDisabled">
        {{ $t("page.dashboard.resources.slug.id.edit.action.update.label") }}
      </UiButton>
    </div>

    <DevCard>
      <DevCardCode title="generalForm" v-model="generalForm" />
      <DevCardCode title="generalForm.values" v-model="generalForm.values" />
      <DevCardCode title="modelInfo" v-model="modelInfo" />
      <DevCardCode title="entryFormSchema" v-model="entryFormSchema" />
    </DevCard>
  </DashboardPage>
</template>
