import { DefineComponent, Plugin, App as VueApp, createApp, h } from "vue";
import { Page } from "@inertiajs/core";
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

export const laravelInput = ["vendor/contentstash/core/resources/js/app.js"];

export const inertiaPagePath = [
  "./Pages/**/*.vue",
  "./../../vendor/contentstash/core/resources/js/Pages/**/*.vue",
];

export const createContentStashApp = (
  params: CreateInertiaAppProps,
): CreateInertiaAppProps => {
  return {
    setup: ({ el, App, props, plugin }) => {
      createApp({ render: () => h(App, props) })
        .use(plugin)
        .mount(el);
    },
    resolve: (name: string) => {
      console.info("name", name);

      const appPages2 = import.meta.glob(
        "./../../../resources/js/Pages/**/*.vue",
        { eager: true },
      );
      const corePages2 = import.meta.glob(
        "./../../../vendor/contentstash/core/resources/js/Pages/**/*.vue",
        { eager: true },
      );

      console.info("appPages2", appPages2);
      console.info("corePages2", corePages2);

      const appPages = params.addPages;
      const corePages = params.corePages;

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
            pages[path.replace(basePath, "")?.replace(".vue", "")] = component;
          },
        );
      };

      if (corePages && Object.keys(corePages).length > 0) {
        addPages(
          corePages,
          "../../vendor/contentstash/core/resources/js/Pages/",
        );
      }
      if (appPages && Object.keys(appPages).length > 0) {
        addPages(appPages, "./Pages/");
      }

      console.info("pages2", pages);
      return pages[name];
    },
    ...params,
  };
};

export default {
  laravelInput,
  inertiaPagePath,
  createContentStashApp,
};
