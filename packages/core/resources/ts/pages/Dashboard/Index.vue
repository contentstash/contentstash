<template>
  <DashboardPage :title="$t('page.dashboard.index.meta.title')">
    <DashboardPageHeader>
      <template #title>
        {{ $t("page.dashboard.index.header.title") }}
      </template>
      <template #description>
        {{ $t("page.dashboard.index.header.description") }}
      </template>
    </DashboardPageHeader>

    <Teleport defer to="#header-alerts">
      <AppAlert>
        <template #title>
          {{ $t("page.dashboard.index.alert.getStarted.title") }}
        </template>
        <template #description>
          <i18n-t
            keypath="page.dashboard.index.alert.getStarted.description"
            for="link"
          >
            <AppLink
              :to="{
                name: 'dashboard.resource-builder.create',
              }"
              variant="underline"
            >
              {{ $t("page.dashboard.index.alert.getStarted.link") }}
            </AppLink>
          </i18n-t>
        </template>
      </AppAlert>
    </Teleport>
  </DashboardPage>
</template>
