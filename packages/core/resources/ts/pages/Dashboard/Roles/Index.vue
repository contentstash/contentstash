<script setup lang="ts">
const {
  props: { roles },
}: {
  props: {
    roles: Role[];
  };
} = usePage();
</script>

<template>
  <DashboardPage :title="$t('page.dashboard.roles.index.meta.title')">
    <DashboardPageHeader>
      <template #title>
        {{ $t("page.dashboard.roles.index.header.title") }}
      </template>
      <template #description>
        {{ $t("page.dashboard.roles.index.header.description") }}
      </template>
    </DashboardPageHeader>

    {{ roles }}
    <DevCard>
      <!-- <DevCardCode title="data" v-model="data" /> -->
    </DevCard>
  </DashboardPage>
</template>
