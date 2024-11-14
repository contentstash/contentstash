<script setup lang="ts">
import { Lock } from "lucide-vue-next";

defineProps<{
  attribute: ResourceModelAttribute;
}>();
</script>

<template>
  <div class="flex items-center">
    <ResourceModelAttributesPhpTypeIconBadge
      :type="attribute.phpType"
      class="mr-3"
    />
    <span>{{ attribute.name }}</span>
    <UiTooltipProvider v-if="attribute.locked">
      <UiTooltip>
        <UiTooltipTrigger
          ><Lock :size="16" class="ml-2 opacity-50"
        /></UiTooltipTrigger>
        <UiTooltipContent>
          <p>
            {{
              $t(
                "resource.model.attributes.dataTableColumnNameHeader.locked.tooltip",
              )
            }}
          </p>
        </UiTooltipContent>
      </UiTooltip>
    </UiTooltipProvider>
  </div>
</template>
