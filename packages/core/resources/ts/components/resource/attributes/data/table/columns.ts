import DataTableColumnHeader from "@/components/data/table/ColumnHeader.vue";
import ResourceAttributesDataTableActionsDropDown from "@/components/resource/attributes/data/table/ActionsDropDown.vue";
import ResourceAttributesDataTableColumnName from "@/components/resource/attributes/data/table/ColumnName.vue";
import { h } from "vue";

export const getColumns: TableColumns<PartialResourceAttribute> = ({
  meta,
}) => {
  return [
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
          () => [row.getValue("name")],
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
      cell: ({ row }) => {
        const attribute = row.original;
        return h(
          "div",
          { class: "flex justify-end" },
          h(ResourceAttributesDataTableActionsDropDown, {
            attribute,
            meta,
            row,
          }),
        );
      },
    },
  ];
};
