import type { ColumnDef } from "@tanstack/vue-table";
import DataTableColumnHeader from "@/components/data/table/ColumnHeader.vue";
import ResourceItemsDataTableColumnItem from "@/components/resource/items/data/table/ColumnItem.vue";

// TODO: Migrate to single source of truth (currently we define the types of this in core/resources/ts/types/attribute.d.ts)
enum AttributeTypeFormat {
  Date = "DATE",
  DateTime = "DATETIME",
  Raw = "RAW",
  Time = "TIME",
}

// TODO: Migrate to single source of truth (currently we define the types of this in core/resources/ts/types/resource.d.ts)
enum PartialResourceAttributeStatus {
  NEW = "NEW",
  DELETED = "DELETED",
  UPDATED = "UPDATED",
}

export default function () {
  return {
    PartialResourceAttributeStatus,
    getItemDataTableColumn: <TColumn>({
      attribute,
    }: {
      attribute: ResourceAttribute;
    }): ColumnDef<TColumn> => {
      return {
        accessorKey: attribute.name,
        header: ({ column }) =>
          h(DataTableColumnHeader, {
            column,
            title: attribute.name,
          }),
        cell: ({ row }) => {
          let value = row.getValue(attribute.name);

          // check special formats
          if (
            attribute.attributeType.format == AttributeTypeFormat.DateTime &&
            typeof value === "string"
          ) {
            value = new Date(value).toLocaleString();
          } else if (
            attribute.attributeType.format === AttributeTypeFormat.Date &&
            typeof value === "string"
          ) {
            value = new Date(value).toLocaleDateString();
          } else if (
            attribute.attributeType.format === AttributeTypeFormat.Time &&
            typeof value === "string"
          ) {
            value = new Date(value).toLocaleTimeString();
          }

          return h(ResourceItemsDataTableColumnItem, undefined, value ?? "");
        },
      };
    },
  };
}
