import "./../css/index.css";

import type { DefineComponent, Plugin, App as VueApp } from "vue";
import { createApp, h } from "vue";

import DefaultLayout from "@/layouts/DefaultLayout.vue";
import type { Page } from "@inertiajs/core";
import { defu } from "defu";

interface InertiaAppProps {
  initialPage: Page;
  initialComponent?: object;
  resolveComponent?: (
    name: string,
  ) => DefineComponent | Promise<DefineComponent>;
  titleCallback?: (title: string) => string;
  onHeadUpdate?: (elements: string[]) => void;
}
type InertiaApp = DefineComponent<InertiaAppProps>;

interface CreateInertiaAppProps {
  id?: string;
  resolve: (name: string) =>
    | DefineComponent
    | Promise<DefineComponent>
    | {
        default: DefineComponent;
      };
  setup: (props: {
    el: Element;
    App: InertiaApp;
    props: InertiaAppProps;
    plugin: Plugin;
  }) => void | VueApp;
  title?: (title: string) => string;
  progress?:
    | false
    | {
        delay?: number;
        color?: string;
        includeCSS?: boolean;
        showSpinner?: boolean;
      };
  page?: Page;
  render?: (app: VueApp) => Promise<string>;
}

export const createContentStashApp = (
  props: Partial<
    CreateInertiaAppProps & {
      layouts?: Record<string, DefineComponent>;
      layoutsPath?: string;
      pages?: Record<string, DefineComponent>;
      pagesPath?: string;
    }
  >,
): CreateInertiaAppProps => {
  return defu(
    {
      setup: ({ el, App, props, plugin }) => {
        createApp({ render: () => h(App, props) })
          .use(plugin)
          .mount(el);
      },
      resolve: (name: string) => {
        // get core layouts
        const coreLayouts = import.meta.glob("./layouts/*.vue", {
          eager: true,
        }) as Record<string, DefineComponent>;

        // merge all layout sources
        const layouts: Record<string, DefineComponent> = defu(
          props.layouts
            ? Object.fromEntries(
                Object.entries(props.layouts).map(([key, value]) => [
                  key
                    .replace(props.layoutsPath ?? "./layouts/", "")
                    .replace(".vue", ""),
                  value,
                ]),
              )
            : {},
          Object.fromEntries(
            Object.entries(coreLayouts).map(([key, value]) => [
              key.replace("./layouts/", "").replace(".vue", ""),
              value,
            ]),
          ),
        );

        // get core pages
        const corePages = import.meta.glob("./pages/**/*.vue", {
          eager: true,
        }) as Record<string, DefineComponent>;

        // merge all page sources
        const pages: Record<string, DefineComponent> = defu(
          props.pages
            ? Object.fromEntries(
                Object.entries(props.pages).map(([key, value]) => [
                  key
                    .replace(props.pagesPath ?? "./pages/", "")
                    .replace(".vue", ""),
                  value,
                ]),
              )
            : {},
          Object.fromEntries(
            Object.entries(corePages).map(([key, value]) => [
              key.replace("./pages/", "").replace(".vue", ""),
              value,
            ]),
          ),
        );

        const page = pages[name];

        console.info("FOUND PAGE", pages[name]);

        // name would be camelCase (should be UpperCamelCase) and should end with Layout (if its not ending with Layout already)
        // e.g. if name is "home" it should be "HomeLayout"
        // e.g. if name is "homeLayout" it should be "HomeLayout"
        // e.g. if name is "Home" it should be "HomeLayout"
        const parsedLayoutName = ({ name }: { name: string }) => {
          let layoutName = name;
          if (!layoutName.endsWith("Layout")) {
            layoutName += "Layout";
          }
          return layoutName.charAt(0).toUpperCase() + layoutName.slice(1);
        };

        if (page.default.layout === false) {
          // do nothing
        } else if (typeof page.default.layout == "string") {
          page.default.layout =
            layouts[parsedLayoutName({ name: page.default.layout })].default;
        } else if (!page.default.layout) {
          page.default.layout = DefaultLayout;
        }

        return page;
      },
    },
    props,
  );
};

export default {
  createContentStashApp,
};
