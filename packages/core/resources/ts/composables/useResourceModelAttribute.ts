import type { ColumnDef } from "@tanstack/vue-table";
import DataTableColumnHeader from "@/components/data/table/ColumnHeader.vue";
import ResourceItemsDataTableColumnAttributeTypeText from "@/components/resource/items/data/table/ColumnAttributeTypeText.vue";

export default function () {
  type PHP_TYPES =
    | "string"
    | "int"
    | "CarbonCarbonInterface"
    | "array"
    | "mixed"
    | "bool";
  const PHP_TYPE: Record<PHP_TYPES, ResourceModelAttributePhpType> = {
    string: "string",
    int: "int",
    CarbonCarbonInterface: "\\Carbon\\CarbonInterface",
    array: "array",
    mixed: "mixed",
    bool: "bool",
  };
  type TYPES = "bigint" | "text" | "json" | "unknown" | "boolean";
  const TYPE: Record<TYPES, ResourceModelAttributeType> = {
    bigint: "bigint",
    text: "text",
    json: "json",
    unknown: "unknown",
    boolean: "boolean",
  };

  const getCellComponent = ({
    attribute,
  }: {
    attribute: ResourceModelAttribute;
  }) => {
    if (attribute.type === TYPE.text) {
      return ResourceItemsDataTableColumnAttributeTypeText;
    }

    return "div";
  };
  const parseCellValue = ({
    attribute,
    value,
  }: {
    attribute: ResourceModelAttribute;
    value?: string;
  }): string | undefined => {
    if (!value) {
      return value;
    }

    if (attribute.phpType === PHP_TYPE.CarbonCarbonInterface) {
      return new Date(value as string | number).toLocaleString();
    } else if (attribute.phpType === PHP_TYPE.array) {
      return JSON.stringify(value);
    }

    return value;
  };

  return {
    PHP_TYPE,
    TYPE,
    getItemDataTableColumn: <TColumn>({
      attribute,
    }: {
      attribute: ResourceModelAttribute;
    }): ColumnDef<TColumn> => {
      return {
        accessorKey: attribute.name,
        header: ({ column }) =>
          h(DataTableColumnHeader, {
            column,
            title: attribute.name,
          }),
        cell: ({ row }) => {
          return h(
            getCellComponent({ attribute }),
            undefined,
            parseCellValue({
              attribute,
              value: row.getValue(attribute.name),
            }),
          );
        },
      };
    },
  };
}
