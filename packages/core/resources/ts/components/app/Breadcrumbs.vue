<script setup lang="ts">
import { router } from "@inertiajs/vue3";

const breadcrumbs = ref<
  {
    to: Route;
    title: string;
  }[]
>([]);

const route = inject("route");
const setBreadcrumbs = () => {
  const currentRouteName = route().current();
  breadcrumbs.value = [];

  const nameParts = currentRouteName.split(".");
  for (let i = 0; i < nameParts.length; i++) {
    const name = `${nameParts.slice(0, i + 1).join(".")}.index`;
    if (route().has(name)) {
      breadcrumbs.value.push({
        to: {
          name: name,
        },
        title: `page.${name}.title`,
      });
    }
  }

  if (
    breadcrumbs.value.length != 1 ||
    breadcrumbs.value[0].to.name != currentRouteName
  ) {
    breadcrumbs.value.push({
      to: route().current(),
      title: `page.${currentRouteName}.title`,
    });
  }
};
const removeSuccessEventListener = router.on("success", (event) => {
  setBreadcrumbs();
});
onBeforeUnmount(() => {
  removeSuccessEventListener();
});
onMounted(() => {
  setBreadcrumbs();
});
</script>

<template>
  <UiBreadcrumb>
    <UiBreadcrumbList>
      <template v-for="(breadcrumb, index) in breadcrumbs" :key="index">
        <UiBreadcrumbSeparator v-if="index > 0" />
        <UiBreadcrumbItem>
          <UiBreadcrumbLink v-if="index < breadcrumbs.length - 1" as-child>
            <AppLink :to="breadcrumb.to">
              {{ $t(breadcrumb.title) }}
            </AppLink>
          </UiBreadcrumbLink>
          <UiBreadcrumbPage v-else>
            {{ $t(breadcrumb.title) }}
          </UiBreadcrumbPage>
        </UiBreadcrumbItem>
      </template>
    </UiBreadcrumbList>
  </UiBreadcrumb>
</template>
