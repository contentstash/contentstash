import { createApp, h } from "vue";
import type { DefineComponent, Plugin, App as VueApp } from "vue";
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
declare const App: InertiaApp;

import "./../css/index.css";

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
  props: Partial<CreateInertiaAppProps>,
): CreateInertiaAppProps => {
  return defu(
    {
      setup: ({ el, App, props, plugin }) => {
        createApp({ render: () => h(App, props) })
          .use(plugin)
          .mount(el);
      },
      resolve: (name: string) => {
        // get pages
        const corePages = import.meta.glob("./pages/**/*.vue", {
          eager: true,
        }) as Record<string, DefineComponent>;
        const appPages = import.meta.glob(
          "./../../../resources/ts/pages/**/*.vue",
          { eager: true },
        ) as Record<string, DefineComponent>;
        const pages: Record<string, DefineComponent> = {};
        const addPages = (
          sourcePages: Record<string, DefineComponent>,
          basePath: string,
        ) => {
          // check if sourcePages is an object
          if (typeof sourcePages !== "object") {
            console.info("sourcePages", sourcePages);
            return;
          }

          return Object.entries(sourcePages).forEach(
            ([path, component]: [string, DefineComponent]) => {
              pages[path.replace(basePath, "")?.replace(".vue", "")] =
                component;
            },
          );
        };
        if (corePages && Object.keys(corePages).length > 0) {
          addPages(corePages, "./pages/");
        }
        if (appPages && Object.keys(appPages).length > 0) {
          addPages(appPages, "./../../../resources/ts/pages/");
        }

        return pages[name];
      },
    },
    props,
  );
};

export default {
  createContentStashApp,
};
