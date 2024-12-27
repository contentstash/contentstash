export {};

declare global {
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
}
