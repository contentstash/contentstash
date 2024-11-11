import { route as routeFn } from "ziggy-js";

declare global {
  const route: typeof routeFn;

  type Route = {
    name: string;
    params?: Record<string, string | number>;
    query?: Record<string, string | number>;
  };
}
