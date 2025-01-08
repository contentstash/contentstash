<script setup lang="ts">
import { getColumns } from "@/components/resource/attributes/data/table/columns";
import { toTypedSchema } from "@vee-validate/zod";
import { z } from "zod";

const {
  props: { attributeTypes },
}: {
  props: {
    attributeTypes: AttributeType[];
  };
} = usePage();
const { t } = useI18n();

// general form
const generalFormSchema = z.object({
  model: z.string().refine((value) => /^[A-Z][a-zA-Z]*$/.test(value), {
    message: t(
      "page.dashboard.resource-builder.create.general.form.model.validation.regex.message",
    ),
  }),
});
const generalFieldConfig = {
  model: {
    label: t("page.dashboard.resource-builder.create.general.form.model.label"),
    inputProps: {
      type: "text",
      placeholder: t(
        "page.dashboard.resource-builder.create.general.form.model.placeholder",
      ),
    },
  },
};
const generalForm = useForm({
  validationSchema: toTypedSchema(generalFormSchema),
});

// table
const { setTable, getTable } = useTables();
const tableMeta = setTable<PartialResourceAttribute, PartialResourceAttribute>({
  uid: `${useRoute().current()}-resource-attributes-data-table`,
  table: {
    rows: [
      {
        name: "id",
        nullable: false,
        attributeType: attributeTypes.find(
          (attributeType) => attributeType.name === "bigint",
        )!,
        locked: true,
        default: "",
      },
    ],
    columns: getColumns,
  },
});

const data = computed(() => {
  return (
    getTable<unknown, PartialResourceAttribute>({ meta: tableMeta })?.rows ?? []
  );
});
const { PartialResourceAttributeStatus } = useResourceAttribute();
const formData = computed(() => {
  return data.value
    .filter((row) => row.status !== PartialResourceAttributeStatus.DELETED)
    .reduce(
      (acc, row) => {
        const key = (row.original?.name as string) ?? row.name;
        const { original, status, locked, ...rest } = row;
        acc[key] = {
          ...rest,
          attributeType: row.attributeType.name,
        };
        return acc;
      },
      // TODO: add type
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      {} as Record<string, any>,
    );
});

// store
const storeButtonIsDisabled = computed(() => {
  return (
    !data.value.some((row) => row.status) && !generalForm.meta.value?.valid
  );
});
const storeRoute = useRoute("dashboard.resource-builder.store");
const storeHandler = () => {
  useRouter().post(storeRoute, {
    ...generalForm.values,
    data: {
      ...formData.value,
    },
  });
};
</script>

<template>
  <DashboardPage
    :title="$t('page.dashboard.resource-builder.create.meta.title')"
  >
    <DashboardPageHeader>
      <template #title>
        {{ $t("page.dashboard.resource-builder.create.header.title") }}
      </template>
      <template #description>
        {{ $t("page.dashboard.resource-builder.create.header.description") }}
      </template>
    </DashboardPageHeader>

    <UiCard>
      <UiCardHeader>
        <UiCardTitle>
          {{ $t("page.dashboard.resource-builder.create.general.title") }}
        </UiCardTitle>
        <UiCardDescription>
          {{ $t("page.dashboard.resource-builder.create.general.description") }}
        </UiCardDescription>
      </UiCardHeader>
      <UiCardContent>
        <UiAutoForm
          :form="generalForm"
          :schema="generalFormSchema"
          :fieldConfig="generalFieldConfig"
        />
      </UiCardContent>
    </UiCard>

    <ResourceAttributesDataTable :meta="tableMeta" v-model:data="data" />

    <div class="flex justify-end gap-2">
      <UiButton @click="storeHandler()" :disabled="storeButtonIsDisabled">
        {{ $t("page.dashboard.resource-builder.create.action.store.label") }}
      </UiButton>
    </div>

    <DevCard>
      <DevCardCode title="formData" v-model="formData" />
      <DevCardCode title="data" v-model="data" />
    </DevCard>
  </DashboardPage>
</template>
