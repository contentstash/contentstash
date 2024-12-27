type TableColumn<T> = T;

type TableRow<T = unknown> = T & {
  [key: string]: unknown;
};

type Table<ColumnT = unknown, RowT = unknown> = {
  columns?: TableColumn<ColumnT>[];
  rows: TableRow<RowT>[];
};

type TableUid = string;

type TableMeta = {
  uid: TableUid;
};

export const useTablesStore = defineStore("tables", () => {
  /************************************************
   * Helpers                                      *
   ************************************************/

  /**
   * Helper function to get the uid from params
   *
   * @param params - Object containing the required parameters
   * @param params.uid - The unique identifier of the table (optional if `meta` is provided)
   * @param params.meta - The meta information of the table (optional if `uid` is provided)
   * @returns The uid of the table
   * @throws Error if neither `uid` nor `meta` is provided
   */
  const getUid = (params: { uid?: TableUid; meta?: TableMeta }): TableUid => {
    if (params.uid) {
      return params.uid;
    } else if (params.meta) {
      return params.meta.uid;
    } else {
      throw new Error("Either uid or meta must be provided");
    }
  };

  /************************************************
   * Tables                                       *
   ************************************************/
  const tables = ref<Record<string, Table>>({});
  const tableUIDs = computed<TableUid[]>(() => Object.keys(tables.value));
  const tablesMeta = computed<TableMeta[]>(() =>
    tableUIDs.value.map((uid) => ({
      uid,
    })),
  );

  /**
   * Clears all tables from the store.
   */
  const reset = () => {
    tables.value = {};
  };

  /************************************************
   * Table management                             *
   ************************************************/

  /**
   * Get a table by its uid or meta
   *
   * @param params - Object containing parameters to identify the table
   * @param params.uid - The unique identifier of the table (optional if `meta` is provided)
   * @param params.meta - The meta information of the table (optional if `uid` is provided)
   * @param params.strict - If true, an error is thrown if the table is not found (default: true)
   * @returns The requested table or `undefined` if not found and `strict` is false
   */
  const getTable = <ColumnT, RowT>({
    strict = true,
    ...params
  }: {
    uid?: TableUid;
    meta?: TableMeta;
    strict?: boolean;
  }): Table<ColumnT, RowT> | undefined => {
    const uid = getUid(params);

    if (!tables.value[uid]) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      } else {
        return undefined;
      }
    }

    return tables.value[uid] as Table<ColumnT, RowT>;
  };

  /**
   * Add a new table
   *
   * @param params - Object containing the table details
   * @param params.uid - The unique identifier for the new table
   * @param params.table - The table object to add
   * @returns The meta of the added table
   * @throws Error if a table with the same uid already exists
   */
  const addTable = <ColumnT, RowT>({
    uid,
    table,
  }: {
    uid: TableUid;
    table: Table<ColumnT, RowT>;
  }): TableMeta => {
    if (tables.value[uid]) {
      throw new Error(`Table with uid ${uid} already exists`);
    }

    tables.value[uid] = table;
    return { uid };
  };

  /**
   * Set (replace) a table
   *
   * @param params - Object containing the table details
   * @param params.uid - The unique identifier for the table to set
   * @param params.table - The new table object to set
   * @returns The meta of the updated table
   */
  const setTable = <ColumnT, RowT>({
    uid,
    table,
  }: {
    uid: TableUid;
    table: Table<ColumnT, RowT>;
  }): TableMeta => {
    if (tables.value[uid]) {
      delete tables.value[uid];
    }

    tables.value[uid] = table;
    return { uid };
  };

  /**
   * Remove a table
   *
   * @param params - Object containing parameters to identify the table
   * @param params.uid - The unique identifier of the table (optional if `meta` is provided)
   * @param params.meta - The meta information of the table (optional if `uid` is provided)
   * @param params.strict - If true, an error is thrown if the table is not found (default: true)
   * @returns The meta of the removed table or `undefined` if not found and `strict` is false
   * @throws Error if the table does not exist and `strict` is true
   */
  const removeTable = ({
    strict = true,
    ...params
  }: {
    uid?: TableUid;
    meta?: TableMeta;
    strict?: boolean;
  }): TableMeta | undefined => {
    const uid = getUid(params);

    if (!tables.value[uid]) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      } else {
        return undefined;
      }
    }

    delete tables.value[uid];
    return { uid };
  };

  /************************************************
   * Row Management                               *
   ************************************************/

  /**
   * Add a row to a table
   *
   * @param params - Object containing parameters for the operation
   * @param params.uid - The unique identifier of the table (optional if `meta` is provided)
   * @param params.meta - The meta information of the table (optional if `uid` is provided)
   * @param params.row - The row object to add
   * @param params.strict - If true, an error is thrown if the table is not found (default: true)
   * @throws Error if the table does not exist and `strict` is true
   */
  const addRow = <RowT>({
    row,
    strict = true,
    ...params
  }: {
    uid?: TableUid;
    meta?: TableMeta;
    row: TableRow<RowT>;
    strict?: boolean;
  }): void => {
    const uid = getUid(params);

    const table = tables.value[uid];
    if (!table) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      } else {
        return;
      }
    }

    table.rows.push(row);
  };

  /**
   * Remove a row from a table
   *
   * @param params - Object containing parameters for the operation
   * @param params.uid - The unique identifier of the table (optional if `meta` is provided)
   * @param params.meta - The meta information of the table (optional if `uid` is provided)
   * @param params.index - The index of the row to remove
   * @param params.strict - If true, an error is thrown if the table or row is not found (default: true)
   * @throws Error if the table or row does not exist and `strict` is true
   */
  const removeRow = ({
    strict = true,
    index,
    ...params
  }: {
    uid?: TableUid;
    meta?: TableMeta;
    index: number;
    strict?: boolean;
  }): void => {
    const uid = getUid(params);

    const table = tables.value[uid];
    if (!table) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      } else {
        return;
      }
    }

    if (index < 0 || index >= table.rows.length) {
      if (strict) {
        throw new Error(`Row index ${index} is out of bounds`);
      } else {
        return;
      }
    }

    table.rows.splice(index, 1);
  };

  /**
   * Update a row in a table
   *
   * @param params - Object containing parameters for the operation
   * @param params.uid - The unique identifier of the table (optional if `meta` is provided)
   * @param params.meta - The meta information of the table (optional if `uid` is provided)
   * @param params.index - The index of the row to update
   * @param params.row - The new row object
   * @param params.strict - If true, an error is thrown if the table or row is not found (default: true)
   * @throws Error if the table or row does not exist and `strict` is true
   */
  const updateRow = <RowT>({
    row,
    index,
    strict = true,
    ...params
  }: {
    uid?: TableUid;
    meta?: TableMeta;
    index: number;
    row: TableRow<RowT>;
    strict?: boolean;
  }): void => {
    const uid = getUid(params);

    const table = tables.value[uid];
    if (!table) {
      if (strict) {
        throw new Error(`Table with uid ${uid} does not exist`);
      } else {
        return;
      }
    }

    if (index < 0 || index >= table.rows.length) {
      if (strict) {
        throw new Error(`Row index ${index} is out of bounds`);
      } else {
        return;
      }
    }

    table.rows[index] = row;
  };

  return {
    tables,
    tableUIDs,
    tablesMeta,
    reset,
    getTable,
    addTable,
    setTable,
    removeTable,
    addRow,
    removeRow,
    updateRow,
  };
});
