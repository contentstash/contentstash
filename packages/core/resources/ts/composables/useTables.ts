import { useTablesStore } from "@/stores/table";

export default function () {
  const tableStore = useTablesStore();
  const tableStoreRefs = storeToRefs(tableStore);

  return {
    ...tableStore,
    ...tableStoreRefs,
  };
}
