import type { ColumnDef } from "@tanstack/vue-table";

export {};

declare global {
  type TableColumnParams = {
    meta: TableMeta;
  };
  type TableColumns<ColumnT = unknown> = (
    params: TableColumnParams,
  ) => ColumnDef<ColumnT>[];

  type TableRow<T = unknown> = T & {
    [key: string]: unknown;
  };

  type Table<ColumnT = unknown, RowT = unknown> = {
    columns: TableColumns<ColumnT>;
    rows: TableRow<RowT>[];
  };

  type TableUid = string;

  type TableMeta = {
    uid: TableUid;
  };
}
