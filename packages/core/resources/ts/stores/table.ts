type TableColumn<T> = T;

type TableRow<T = unknown> = T & {
  [key: string]: unknown;
};

type Table<ColumnT = unknown, RowT = unknown> = {
  columns?: TableColumn<ColumnT>[];
  rows: TableRow<RowT>[];
};

export const useTablesStore = defineStore("tables", () => {
  /************************************************
   * Tables                                       *
   ************************************************/
  const tables = ref<Record<string, Table>>({});
  const tableUIDs = computed(() => Object.keys(tables.value));

  /**
   * Reset the store
   */
  const reset = () => {
    tables.value = {};
  };

  /************************************************
   * Table                                        *
   ************************************************/

  /**
   * Get a table by its uid
   *
   * @param uid - The uid of the table
   *
   */
  const getTable = ({ uid }: { uid: string }) => {
    return tables.value[uid] ?? undefined;
  };

  /**
   * Add a new table to the store
   *
   * @param uid - The uid of the table
   * @param table - The table to add
   *
   * @throws {Error} - If the table already exists
   */
  const addTable = <ColumnT, RowT>({
    uid,
    table,
  }: {
    uid: string;
    table: Table<ColumnT, RowT>;
  }) => {
    // check if table already exists
    if (tables.value[uid]) {
      throw new Error(`Table with uid ${uid} already exists`);
    }

    // add table
    tables.value[uid] = table;
  };

  /**
   * Remove a table from the store
   *
   * @param uid - The uid of the table
   * @param strict - If true, throw an error if the table does not exist
   *
   * @throws {Error} - If the table does not exist and strict is true
   */
  const removeTable = ({
    uid,
    strict = true,
  }: {
    uid: string;
    strict?: boolean;
  }) => {
    // check if table exists and strict is true
    if (!tables.value[uid]) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      }

      return;
    }

    // remove table
    delete tables.value[uid];
  };

  /************************************************
   * Table row                                    *
   ************************************************/

  /**
   * Add a row to a table
   *
   * @param uid - The uid of the table
   * @param row - The row to add
   * @param strict - If true, throw an error if the table does not exist
   *
   * @throws {Error} - If the table does not exist and strict is true
   */
  const addRow = ({
    uid,
    row,
    strict = true,
  }: {
    uid: string;
    row: TableRow;
    strict?: boolean;
  }) => {
    // check if table exists
    if (!tables.value[uid]) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      }

      return;
    }

    // add row
    tables.value[uid].rows.push(row);
  };

  /**
   * Remove a row from a table
   *
   * @param uid - The uid of the table
   * @param index - The index of the row to remove
   * @param strict - If true, throw an error if the table does not exist
   *
   * @throws {Error} - If the table does not exist and strict is true
   */
  const removeRow = ({
    uid,
    index,
    strict = true,
  }: {
    uid: string;
    index: number;
    strict?: boolean;
  }) => {
    // check if table exists
    if (!tables.value[uid]) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      }

      return;
    }

    // remove row
    tables.value[uid].rows.splice(index, 1);
  };

  /**
   * Update a row in a table
   *
   * @param uid - The uid of the table
   * @param index - The index of the row to update
   * @param row - The row to update
   * @param strict - If true, throw an error if the table does not exist
   *
   * @throws {Error} - If the table does not exist and strict is true
   */
  const updateRow = ({
    uid,
    index,
    row,
    strict = true,
  }: {
    uid: string;
    index: number;
    row: TableRow;
    strict?: boolean;
  }) => {
    // check if table exists
    if (!tables.value[uid]) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      }

      return;
    }

    // update row
    tables.value[uid].rows[index] = row;
  };

  return {
    tables,
    tableUIDs,
    reset,
    getTable,
    addTable,
    removeTable,
    addRow,
    removeRow,
    updateRow,
  };
});
