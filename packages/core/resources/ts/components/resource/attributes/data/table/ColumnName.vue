<script setup lang="ts">
import { Lock } from "lucide-vue-next";
const { attribute } = defineProps<{
  attribute: PartialResourceAttribute;
}>();

const { PartialResourceAttributeStatus } = useResourceAttribute();
const statusBadgeVariant = computed(() => {
  if (attribute.status === PartialResourceAttributeStatus.NEW) {
    return "default";
  } else if (attribute.status === PartialResourceAttributeStatus.UPDATED) {
    return "secondary";
  } else if (attribute.status === PartialResourceAttributeStatus.DELETED) {
    return "destructive";
  } else {
    return "outline";
  }
});
</script>

<template>
  <div class="flex items-center gap-3">
    <AttributeTypeLucideIconBadge
      :icon="attribute.attributeType?.icon"
      :class="attribute.attributeType?.classes?.badge"
    />
    <span>{{ attribute.name }}</span>
    <UiBadge v-if="attribute.status" :variant="statusBadgeVariant">
      {{ $t(`resource.attribute.status.${attribute.status}.label`) }}
    </UiBadge>

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
