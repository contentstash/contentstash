<script setup lang="ts">
import { toTypedSchema } from "@vee-validate/zod";
import { z } from "zod";

const {
  props: { role, permissions },
}: {
  props: {
    role: Role;
    permissions: Permission[];
  };
} = usePage();

// general form
const { t } = useI18n();
const generalFormSchema = z.object({
  name: z.string(),
});
const generalFormFieldConfig = {
  name: {
    label: t("role.name.label"),
    inputProps: {
      type: "text",
      placeholder: t("role.name.placeholder"),
      disabled: role.is_system,
    },
  },
};
const generalForm = useForm({
  validationSchema: toTypedSchema(generalFormSchema),
});
const submitButtonIsDisabled = computed(() => {
  return !generalForm.meta.value?.valid;
});
generalForm.setValues({
  name: role.name,
});

// permissions
const permissionsGroup = computed(() => {
  // split on the first space and use last part as group name
  return permissions.reduce(
    (acc, permission) => {
      const [action, ...rest] = permission.name.split(" ");
      const groupName = rest.join(" ");
      if (!acc[groupName]) {
        acc[groupName] = [];
      }
      acc[groupName].push({
        ...permission,
      });
      return acc;
    },
    {} as Record<string, Permission[]>,
  );
});
const selectedPermissions = ref<Record<string, boolean>>({});
role.permissions.forEach((permission) => {
  selectedPermissions.value[permission.name] = true;
});
const clickCheckbox = ({ permission }: { permission: Permission }) => {
  selectedPermissions.value[permission.name] =
    !selectedPermissions.value[permission.name];
};

// update route
const updateRoute = useRoute("dashboard.roles.update", {
  id: role.id,
});
const updateHandler = async () => {
  useRouter().put(updateRoute, {
    ...generalForm.values,
    permissions: Object.entries(selectedPermissions.value)
      .filter(([, value]) => value)
      .map(([key]) => key),
  });
};
</script>

<template>
  <DashboardPage
    :title="
      $t('page.dashboard.roles.id.edit.meta.title', {
        roleName: role.name,
      })
    "
  >
    <DashboardPageHeader>
      <template #title>
        <div class="flex items-center gap-2">
          <div>
            {{
              $t("page.dashboard.roles.id.edit.header.title", {
                roleName: role.name,
              })
            }}
          </div>
          <UiBadge v-if="role.is_system" variant="destructive">
            {{ $t("role.is_system.label") }}
          </UiBadge>
        </div>
      </template>
      <template #description>
        {{ $t("page.dashboard.roles.id.edit.header.description") }}
      </template>
    </DashboardPageHeader>

    <UiCard>
      <UiCardHeader>
        <UiCardTitle class="text-2xl">
          {{ $t("page.dashboard.roles.id.edit.general.title") }}
        </UiCardTitle>
        <UiCardDescription>
          {{ $t("page.dashboard.roles.id.edit.general.description") }}
        </UiCardDescription>
      </UiCardHeader>
      <UiCardContent>
        <UiAutoForm
          :form="generalForm"
          :schema="generalFormSchema"
          :fieldConfig="generalFormFieldConfig"
        />
      </UiCardContent>
    </UiCard>

    <UiCard>
      <UiCardHeader>
        <UiCardTitle class="text-2xl">
          {{ $t("page.dashboard.roles.id.edit.permissions.title") }}
        </UiCardTitle>
        <UiCardDescription>
          {{ $t("page.dashboard.roles.id.edit.permissions.description") }}
        </UiCardDescription>
      </UiCardHeader>

      <UiCardContent>
        <ul class="flex flex-col gap-4">
          <li
            v-for="(permissions, groupName) in permissionsGroup"
            :key="groupName"
            class="flex flex-col gap-2"
          >
            <span class="text-xl">{{ groupName }}</span>
            <div class="flex flex-row flex-wrap gap-4">
              <div
                v-for="permission in permissions"
                :key="permission.id"
                class="flex items-center gap-2"
              >
                <UiCheckbox
                  :id="`permission-${permission.id}`"
                  :checked="selectedPermissions[permission.name]"
                  @click="clickCheckbox({ permission })"
                />
                <label :for="`permission-${permission.id}`">
                  {{ permission.name }}
                </label>
              </div>
            </div>
          </li>
        </ul>
      </UiCardContent>
    </UiCard>

    <div class="flex justify-end gap-2">
      <UiButton @click="updateHandler()" :disabled="submitButtonIsDisabled">
        {{ $t("action.save.label") }}
      </UiButton>
    </div>

    <DevCard>
      <DevCardCode title="role" v-model="role" />
      <DevCardCode title="permissions" v-model="permissions" />
    </DevCard>
  </DashboardPage>
</template>
