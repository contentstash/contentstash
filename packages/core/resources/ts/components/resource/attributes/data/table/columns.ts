import type { ColumnDef } from "@tanstack/vue-table";
import DataTableColumnHeader from "@/components/data/table/ColumnHeader.vue";
import ResourceAttributesDataTableColumnName from "@/components/resource/attributes/data/table/ColumnName.vue";
import ResourceAttributesDataTableDropdownAction from "@/components/resource/attributes/data/table/DropDown.vue";
import { h } from "vue";

export const columns: ColumnDef<ResourceAttribute>[] = [
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
        ResourceAttributesDataTableColumnName,
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
      const { t } = useI18n();
      return h(
        "div",
        undefined,
        t(
          `attributeType.${row.original?.attributeType?.name ?? "unknown"}.label`,
        ),
      );
    },
  },
  {
    id: "actions",
    enableHiding: false,
    cell: ({ row, table }) => {
      const attribute = row.original;
      return h(
        "div",
        { class: "flex justify-end" },
        h(ResourceAttributesDataTableDropdownAction, {
          attribute,
          row,
          table,
        }),
      );
    },
  },
];
