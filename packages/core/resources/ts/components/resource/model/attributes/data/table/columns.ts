import type { ColumnDef } from "@tanstack/vue-table";
import DataTableColumnHeader from "@/components/data/table/ColumnHeader.vue";
import ResourceModelAttributesDataTableColumnName from "@/components/resource/model/attributes/data/table/ColumnName.vue";
import ResourceModelAttributesDataTableDropdownAction from "@/components/resource/model/attributes/data/table/DropDown.vue";
import { h } from "vue";

export const columns: ColumnDef<ResourceModelAttribute>[] = [
  {
    accessorKey: "name",
    enableHiding: false,
    header: ({ column }) =>
      h(DataTableColumnHeader, {
        column,
        title: "Name",
      }),
    cell: ({ row }) => {
      return h(
        ResourceModelAttributesDataTableColumnName,
        { attribute: row.original },
        row.getValue("name"),
      );
    },
  },
  {
    accessorKey: "attributeType",
    header: ({ column }) =>
      h(DataTableColumnHeader, {
        column,
        title: "attributeType",
      }),
    cell: ({ row }) => {
      return h("div", undefined, row.original?.attributeType.name);
    },
  },
  {
    id: "actions",
    enableHiding: false,
    cell: ({ row }) => {
      const attribute = row.original;

      return h(
        "div",
        { class: "flex justify-end" },
        h(ResourceModelAttributesDataTableDropdownAction, {
          attribute,
        }),
      );
    },
  },
];
