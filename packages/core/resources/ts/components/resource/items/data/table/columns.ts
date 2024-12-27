import ResourceItemsDataTableActionDropDown from "@/components/resource/items/data/table/ActionDropDown.vue";
import { h } from "vue";

export const getColumns: TableColumns<ResourceItem> = ({ meta }) => {
  return [
    {
      id: "actions",
      enableHiding: false,
      cell: ({ row }) => {
        return h(
          "div",
          { class: "flex justify-end" },
          h(ResourceItemsDataTableActionDropDown, {
            meta,
            row,
          }),
        );
      },
    },
  ];
};
