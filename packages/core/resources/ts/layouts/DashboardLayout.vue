<script setup lang="ts">
import type { SidebarGroup } from "@/components/dashboard/sidebar/Group.vue";
import {
  BookOpen,
  Bug,
  ChartSpline,
  Database,
  FileClock,
  Images,
  MessagesSquare,
  PencilRuler,
  ScrollText,
  Settings2,
  Shield,
  Users,
} from "lucide-vue-next";
import type { Props as AppAlertProps } from "@/components/app/Alert.vue";

type PropFlashAlert = {
  title?: string;
  description?: string;
};
const { errors, flash } = defineProps<{
  errors: Record<string, string>;
  flash: {
    error: PropFlashAlert;
    message: PropFlashAlert;
    success: PropFlashAlert;
  };
}>();

// alerts
const alerts = computed(() => {
  const alerts: (AppAlertProps & {
    title?: string;
    description?: string;
  })[] = [];

  for (const [type, alert] of Object.entries(flash)) {
    if (alert) {
      alerts.push({
        type:
          type == "message" || type == "success"
            ? "default"
            : (type as AppAlertProps["type"]),
        title: alert?.title,
        description: alert?.description,
      });
    }
  }

  if (Object.keys(errors).length) {
    for (const error of Object.values(errors)) {
      alerts.push({
        type: "error",
        description: error,
      });
    }
  }

  return alerts;
});

// navigation
const navGroups = computed<SidebarGroup[]>(() => {
  const {
    props: { resources },
  }: {
    props: {
      resources: ResourceData[];
    };
  } = usePage();

  const resourcesLinks = [];
  const resourceBuilderLinks = [];
  for (const resource of resources) {
    resourcesLinks.push({
      title: resource.title,
      to: {
        name: "dashboard.resources.slug.show",
        params: {
          slug: resource.slug,
        },
      },
    });
    resourceBuilderLinks.push({
      title: resource.title,
      to: {
        name: "dashboard.resource-builder.slug.show",
        params: {
          slug: resource.slug,
        },
      },
    });
  }

  return [
    {
      label: "dashboard.sidebar.content.label",
      items: [
        {
          title: "dashboard.sidebar.content.item.resources.label",
          icon: Database,
          items: resourcesLinks,
        },
        {
          title: "dashboard.sidebar.content.item.media.label",
          icon: Images,
          disabled: true,
        },
        {
          title: "dashboard.sidebar.content.item.resourceBuilder.label",
          icon: PencilRuler,
          items: [
            [
              {
                title: "Add new Resource",
                disabled: true,
              },
            ],
            resourceBuilderLinks,
          ],
        },
      ],
    },
    {
      label: "dashboard.sidebar.system.label",
      items: [
        {
          title: "dashboard.sidebar.system.item.auditLog.label",
          icon: FileClock,
          disabled: true,
        },
        {
          title: "dashboard.sidebar.system.item.monitoring.label",
          icon: ChartSpline,
          disabled: true,
        },
        {
          title: "dashboard.sidebar.system.item.users.label",
          icon: Users,
          disabled: true,
        },
        {
          title: "dashboard.sidebar.system.item.roles.label",
          icon: Shield,
          disabled: true,
        },
        {
          title: "dashboard.sidebar.system.item.settings.label",
          icon: Settings2,
          items: [
            {
              title:
                "dashboard.sidebar.system.item.settings.item.general.label",
              disabled: true,
            },
            {
              title:
                "dashboard.sidebar.system.item.settings.item.auditLog.label",
              disabled: true,
            },
            {
              title:
                "dashboard.sidebar.system.item.settings.item.monitoring.label",
              disabled: true,
            },
            {
              title: "dashboard.sidebar.system.item.settings.item.media.label",
              disabled: true,
            },
            {
              title:
                "dashboard.sidebar.system.item.settings.item.plugins.label",
              disabled: true,
            },
          ],
        },
      ],
    },
    {
      label: "dashboard.sidebar.contentStash.label",
      items: [
        {
          title: "dashboard.sidebar.contentStash.item.bugs.label",
          icon: Bug,
          to: "https://github.com/contentstash/contentstash/issues",
        },
        {
          title: "dashboard.sidebar.contentStash.item.changelog.label",
          icon: ScrollText,
          to: "https://github.com/contentstash/contentstash/releases",
        },
        {
          title: "dashboard.sidebar.contentStash.item.community.label",
          icon: MessagesSquare,
          to: "https://github.com/contentstash/contentstash/discussions",
        },
        {
          title: "dashboard.sidebar.contentStash.item.documentation.label",
          icon: BookOpen,
          disabled: true,
        },
      ],
    },
  ];
});
</script>

<template>
  <DashboardSidebar :groups="navGroups">
    <Teleport defer to="#header-errors">
      <AppAlert
        v-for="(alert, index) in alerts"
        :key="index"
        :type="alert.type"
      >
        <template v-if="alert.title" #title>
          {{ alert.title }}
        </template>
        <template v-if="alert.description" #description>
          {{ alert.description }}
        </template>
      </AppAlert>
    </Teleport>

    <header
      class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12"
    >
      <div class="flex items-center gap-2 px-4">
        <UiSidebarTrigger class="-ml-1" />
        <UiSeparator orientation="vertical" class="mr-2 h-4" />
        <AppBreadcrumbs />
      </div>
    </header>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <slot />
    </div>
  </DashboardSidebar>
</template>
