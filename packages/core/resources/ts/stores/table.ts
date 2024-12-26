export const useTablesStore = defineStore("tables", () => {
  // tables
  // TODO: Add type
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const tables = ref<Record<string, any>>({});
  const tableUIDs = computed(() => Object.keys(tables.value));

  /**
   * Reset the store
   */
  const reset = () => {
    tables.value = {};
  };

  // table
  /**
   * Get a table by its uid
   */
  const getTable = ({ uid }: { uid: string }) => {
    return tables.value[uid] ?? undefined;
  };
  /**
   * Add a new table to the store
   */
  // TODO: Add type
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const addTable = ({ uid, table }: { uid: string; table: any }) => {
    // check if table already exists
    if (tables.value[uid]) {
      throw new Error(`Table with uid ${uid} already exists`);
    }

    // add table
    tables.value[uid] = table;
  };
  /**
   * Remove a table from the store
   */
  const removeTable = ({
    uid,
    strict = true,
  }: {
    uid: string;
    strict?: boolean;
  }) => {
    // check if table exists and strict is true
    if (!tables.value[uid] && strict) {
      throw new Error(`Table with uid ${uid} does not exist`);
    }

    // remove table
    delete tables.value[uid];
  };

  return {
    tables,
    tableUIDs,
    reset,
    getTable,
    addTable,
    removeTable,
  };
});
