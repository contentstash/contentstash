<script setup lang="ts">
import type { Row } from "@tanstack/vue-table";
import { MoreHorizontal, Trash2, Pencil } from "lucide-vue-next";
import AppLink from "@/components/app/Link.vue";

const { row, meta } = defineProps<{
  meta: TableMeta;
  row: Row<PartialResourceAttribute>;
}>();
const page = usePage();

// general
const { removeRow } = useTables();

// destroy
const destroyRoute = computed(() => {
  return useRoute("dashboard.resources.slug.id.destroy", {
    slug: page.props.slug as string,
    id: row.original.id,
  });
});
const destroyRouteHandler = () => {
  useRouter().delete(destroyRoute.value);

  removeRow({
    uid: meta.uid,
    index: row.index,
  });
};
</script>

<template>
  <UiDropdownMenu>
    <UiDropdownMenuTrigger as-child>
      <UiButton variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">{{ $t("dropdown.menu.trigger.srOnly") }}</span>
        <MoreHorizontal class="w-4 h-4" />
      </UiButton>
    </UiDropdownMenuTrigger>
    <UiDropdownMenuContent align="end">
      <UiDropdownMenuItem
        :as="AppLink"
        :to="{
          name: 'dashboard.resources.slug.id.edit',
          params: { slug: page.props.slug as string, id: row.original.id },
        }"
      >
        <Pencil />
        {{ $t("action.edit.label") }}
      </UiDropdownMenuItem>
      <UiDropdownMenuItem @click="destroyRouteHandler()">
        <Trash2 />
        {{ $t("action.delete.label") }}
      </UiDropdownMenuItem>
    </UiDropdownMenuContent>
  </UiDropdownMenu>
</template>
