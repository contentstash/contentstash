<script setup lang="ts">
import { Lock } from "lucide-vue-next";
const { attribute } = defineProps<{
  attribute: ResourceAttribute;
}>();
</script>

<template>
  <div class="flex items-center">
    <AttributeTypeLucideIconBadge
      :icon="attribute.attributeType?.icon"
      :class="attribute.attributeType?.classes?.badge"
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
                "resource.model.attributes.data.table.columnNameHeader.locked.tooltip",
              )
            }}
          </p>
        </UiTooltipContent>
      </UiTooltip>
    </UiTooltipProvider>
  </div>
</template>
