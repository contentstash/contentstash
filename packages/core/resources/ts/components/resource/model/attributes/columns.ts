import type { ColumnDef } from "@tanstack/vue-table";
import DataTableColumnHeader from "@/components/data/table/ColumnHeader.vue";
import ResourceModelAttributesDataTableColumnNameHeader from "@/components/resource/model/attributes/DataTableColumnNameHeader.vue";
import ResourceModelAttributesDataTableDropdownAction from "@/components/resource/model/attributes/DataTableDropDown.vue";
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
        ResourceModelAttributesDataTableColumnNameHeader,
        { attribute: row.original },
        row.getValue("name"),
      );
    },
  },
  {
    accessorKey: "phpType",
    header: ({ column }) =>
      h(DataTableColumnHeader, {
        column,
        title: "PHP Type",
      }),
    cell: ({ row }) => {
      return h("div", undefined, row.getValue("phpType"));
    },
  },
  {
    accessorKey: "type",
    header: ({ column }) =>
      h(DataTableColumnHeader, {
        column,
        title: "Type",
      }),
    cell: ({ row }) => {
      return h("div", undefined, row.getValue("type"));
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
