import DataTableColumnHeader from "@/components/data/table/ColumnHeader.vue";
import ResourceAttributesDataTableActionsDropDown from "@/components/resource/attributes/data/table/ActionsDropDown.vue";
import ResourceAttributesDataTableColumnName from "@/components/resource/attributes/data/table/ColumnName.vue";
import { h } from "vue";

export const getColumns: TableColumns<PartialResourceAttribute> = ({
  meta,
}) => {
  const { t } = useI18n();
  return [
    {
      accessorKey: "name",
      enableHiding: false,
      title: t("resource.attribute.name.label"),
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column,
          title: t("resource.attribute.name.label"),
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
      title: t("resource.attribute.attributeType.label"),
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column,
          title: t("resource.attribute.attributeType.label"),
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
      accessorKey: "increments",
      title: t("resource.attribute.increments.label"),
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column,
          title: t("resource.attribute.increments.label"),
        }),
      cell: ({ row }) => {
        return h(
          "div",
          undefined,
          row.original?.increments ? t("yes") : t("no"),
        );
      },
    },
    {
      accessorKey: "nullable",
      title: t("resource.attribute.nullable.label"),
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column,
          title: t("resource.attribute.nullable.label"),
        }),
      cell: ({ row }) => {
        return h("div", undefined, row.original?.nullable ? t("yes") : t("no"));
      },
    },
    {
      accessorKey: "primary",
      title: t("resource.attribute.primary.label"),
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column,
          title: t("resource.attribute.primary.label"),
        }),
      cell: ({ row }) => {
        return h("div", undefined, row.original?.primary ? t("yes") : t("no"));
      },
    },
    {
      accessorKey: "unique",
      title: t("resource.attribute.unique.label"),
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column,
          title: t("resource.attribute.unique.label"),
        }),
      cell: ({ row }) => {
        return h("div", undefined, row.original?.unique ? t("yes") : t("no"));
      },
    },
    {
      id: "actions",
      enableHiding: false,
      cell: ({ row }) => {
        return h(
          "div",
          { class: "flex justify-end" },
          h(ResourceAttributesDataTableActionsDropDown, {
            meta,
            row,
          }),
        );
      },
    },
  ];
};
