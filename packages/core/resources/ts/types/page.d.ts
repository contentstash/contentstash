import type { Page as InertiaPage } from "@inertiajs/core";
import type { DefineComponent } from "vue";

export {};

declare global {
  type PageOptionSingleLayout =
    | string
    | DefinePageComponent
    | DefineComponent
    | false;
  type PageOptionLayout = PageOptionSingleLayout | PageOptionSingleLayout[];
  type PageOptions = {
    layout: PageOptionLayout;
    [key: string]: unknown;
  };
  type Page = InertiaPage & {
    default: Partial<PageOptions>;
  };
  type DefinePageComponent = DefineComponent & {
    default: Partial<PageOptions>;
  };
}
