import type { ColumnDef } from "@tanstack/vue-table";
import ResourceItemsDataTableDropdownAction from "@/components/resource/items/data/table/DropDown.vue";
import { h } from "vue";

export const columns: ColumnDef<ResourceItem>[] = [
  {
    id: "actions",
    enableHiding: false,
    cell: ({ row }) => {
      const item = row.original;

      return h(
        "div",
        { class: "flex justify-end" },
        h(ResourceItemsDataTableDropdownAction, {
          item,
        }),
      );
    },
  },
];
