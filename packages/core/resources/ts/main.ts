import "./../css/index.css";

import type { DefineComponent, Plugin, App as VueApp } from "vue";
import { createApp, h } from "vue";

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

        return pages[name];
      },
    },
    props,
  );
};

export default {
  createContentStashApp,
};
