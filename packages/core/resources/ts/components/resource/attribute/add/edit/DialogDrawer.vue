<script lang="ts">
export const MODE = {
  ADD: "add",
  EDIT: "edit",
};
export const MODES = Object.values(MODE);
export type Mode = (typeof MODE)[keyof typeof MODE];
</script>

<script setup lang="ts">
import Form from "@/components/resource/attribute/add/edit/Form.vue";

defineProps<{
  attributeTypes: AttributeType[];
}>();
defineSlots<{
  trigger?(): HTMLElement;
}>();
const emit = defineEmits<{
  submit: [{ attribute: PartialResourceAttribute }];
}>();
const open = defineModel("open", { type: Boolean });
const attribute = defineModel("attribute", {
  type: Object as PropType<PartialResourceAttribute>,
  default: undefined,
});
const mode: Mode = attribute.value ? MODE.EDIT : MODE.ADD;

// attribute type selection
const selectedAttributeType = defineModel("selectedAttributeType", {
  type: Object as PropType<AttributeType | undefined>,
  default: undefined,
});
const selectAttributeType = ({
  attributeType,
}: {
  attributeType: AttributeType;
}) => {
  selectedAttributeType.value = attributeType;
};

// navigation
const showGoBackButton = computed(
  () => !!selectedAttributeType.value && mode === MODE.ADD,
);
const goBack = () => {
  selectedAttributeType.value = undefined;
};

// form
const form = ref<InstanceType<typeof Form> | undefined>();
const canSave = computed(
  () => !!selectedAttributeType.value && form.value?.isValid,
);
const saveHandler = () => {
  if (!canSave.value || !form.value) {
    return;
  }

  form.value.handleSubmit();
};

const { PartialResourceAttributeStatus } = useResourceAttribute();
const submitHandler = ({ data }: { data: Record<string, unknown> }) => {
  emit("submit", {
    attribute: toRaw({
      attributeType: toRaw(selectedAttributeType.value!),
      status: PartialResourceAttributeStatus.NEW,
      ...data,
    } as PartialResourceAttribute),
  });
  open.value = false;
};

// cleanup on close
const closeResetTimeout = ref<ReturnType<typeof setTimeout> | undefined>();
watch(open, (value) => {
  if (!value) {
    closeResetTimeout.value = setTimeout(() => {
      selectedAttributeType.value = undefined;
    }, 200);
  }
});
onUnmounted(() => {
  if (closeResetTimeout.value) {
    clearTimeout(closeResetTimeout.value);
  }
});
</script>

<template>
  <BaseDialogDrawer v-model:open="open">
    <template #trigger>
      <slot name="trigger" />
    </template>
    <template #title>
      {{
        $t(`resource.attribute.add.edit.dialog.drawer.${mode}.title`, {
          attributeName: attribute?.name,
        })
      }}
    </template>
    <template #description>
      {{
        $t(`resource.attribute.add.edit.dialog.drawer.${mode}.description`, {
          attributeName: attribute?.name,
        })
      }}
    </template>
    <template #default>
      <ul v-if="!selectedAttributeType" class="grid sm:grid-cols-2 gap-2">
        <li
          v-for="(attributeType, index) in attributeTypes"
          :key="index"
          @click="selectAttributeType({ attributeType })"
          class="border hover:bg-muted p-3 rounded-lg hover:cursor-pointer"
        >
          <div class="flex items-center gap-2">
            <AttributeTypeLucideIconBadge
              v-if="attributeType.icon"
              :icon="attributeType.icon"
              :class="attributeType.classes?.badge"
            />
            <span class="ml-2">{{
              $t(`attributeType.${attributeType.name}.label`)
            }}</span>
          </div>
        </li>
      </ul>
      <div v-else>
        <ResourceAttributeAddEditForm
          ref="form"
          :attribute-type="selectedAttributeType"
          :default-values="attribute"
          @submit="submitHandler"
        />
      </div>
    </template>
    <template #footer>
      <GoBackButton v-if="showGoBackButton" @click="goBack" />
      <SaveButton @click="saveHandler" :disabled="!canSave" />
    </template>
  </BaseDialogDrawer>
</template>
