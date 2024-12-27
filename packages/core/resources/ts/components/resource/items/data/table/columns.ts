import ResourceItemsDataTableActionDropDown from "@/components/resource/items/data/table/ActionDropDown.vue";
import { h } from "vue";

export const getColumns: TableColumns<ResourceItem> = () => {
  return [
    {
      id: "actions",
      enableHiding: false,
      cell: ({ row }) => {
        const item = row.original;

        return h(
          "div",
          { class: "flex justify-end" },
          h(ResourceItemsDataTableActionDropDown, {
            item,
          }),
        );
      },
    },
  ];
};
