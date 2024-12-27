import "./../css/index.css";

import type { DefineComponent, Plugin, App as VueApp } from "vue";
import { DrawerClose, DrawerPortal, DrawerTrigger } from "vaul-vue";
import type { InertiaApp, InertiaAppProps } from "@inertiajs/vue3/types/app";
import { createApp, h } from "vue";

import App from "@/App.vue";
import DefaultLayout from "@/layouts/DefaultLayout.vue";
import { ZiggyVue } from "ziggy-js";
import { createPinia } from "pinia";
import { defu } from "defu";
import { fetchRoutes } from "./routes";
import { setupI18n } from "./i18n";

// TODO: Can be removed when this is implemented https://github.com/inertiajs/inertia/discussions/2123
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

export type ContentStashAppProps = Partial<
  CreateInertiaAppProps & {
    layouts: Record<string, DefineComponent>;
    layoutsPath: string;
    pages: Record<string, DefineComponent>;
    pagesPath: string;
  }
>;

/**
 * Get all layouts for the project
 *
 * @param {ContentStashAppProps} props - The props of the app
 *
 * @returns Record<string, DefineComponent>
 */
export const getLayouts = (props: ContentStashAppProps) => {
  // get core layouts
  const coreLayouts = import.meta.glob("./layouts/*.vue", {
    eager: true,
  }) as Record<string, DefineComponent>;

  // merge all layout sources
  return defu(
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
  ) as Record<string, DefineComponent>;
};

/**
 * Get all pages for the project
 *
 * @param {ContentStashAppProps} props - The props of the app
 *
 * @returns Record<string, DefinePageComponent>
 */
export const getPages = (props: ContentStashAppProps) => {
  // get core pages
  const corePages = import.meta.glob("./pages/**/*.vue", {
    eager: true,
  }) as Record<string, DefinePageComponent>;

  // merge all page sources
  return defu(
    props.pages
      ? Object.fromEntries(
          Object.entries(props.pages).map(([key, value]) => [
            key.replace(props.pagesPath ?? "./pages/", "").replace(".vue", ""),
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
  ) as Record<string, DefinePageComponent>;
};

/**
 * Get the parsed layout name
 *
 * @param {string} name - The name of the layout
 *
 * @returns string
 */
export const parsedLayoutName = ({ name }: { name: string }) => {
  let layoutName = name;
  if (!layoutName.endsWith("Layout")) {
    layoutName += "Layout";
  }
  return layoutName.charAt(0).toUpperCase() + layoutName.slice(1);
};

/**
 * Get the layout of a page
 *
 * @param {Record<string, DefineComponent>} layouts - The layouts of the app
 * @param {string} name - The name of the page
 * @param {DefinePageComponent} page - The page object
 * @param {Record<string, DefineComponent>} pages - The pages of the app
 *
 * @returns Array<DefineComponent>
 */
export const getLayout = ({
  layouts,
  name,
  page,
  pages,
}: {
  layouts: Record<string, DefineComponent>;
  name: string;
  page: DefinePageComponent;
  pages: Record<string, DefineComponent>;
}) => {
  // return is layout is already resolved (it is an array) or if it is explicitly set to false
  if (Array.isArray(page.default.layout)) {
    return page.default.layout;
  }

  // result array
  const layoutArray: Array<DefineComponent> = [];

  // get parents by splitting the name and trying to find the parent pages (like nested routes from nuxt https://nuxt.com/docs/guide/directory-structure/pages#nested-routes)
  const segments = name.split("/");
  for (let i = segments.length - 1; i > 0; i--) {
    const parentPageName = segments.slice(0, i).join("/");
    const parentPage = pages[parentPageName];
    if (parentPage) {
      layoutArray.unshift(parentPage.default);
    }
  }

  // if layout is explicitly set to false, return the array only with the parent pages
  if (page.default.layout === false) {
    return layoutArray;
  }

  // if layout is a string, try to find the layout by name else check parent pages for a layout
  if (typeof page.default.layout === "string") {
    const layoutName = parsedLayoutName({ name: page.default.layout });

    if (layouts[layoutName]) {
      layoutArray.unshift(layouts[layoutName].default);
    } else {
      console.warn(`Layout "${layoutName}" not found. Using default layout.`);
    }
  } else if (layoutArray.length) {
    let addDefaultLayout = true;
    for (const layout of layoutArray) {
      if (layout.layout === false) {
        addDefaultLayout = false;
        break;
      } else if (typeof layout.layout === "string") {
        const layoutName = parsedLayoutName({
          name: layout.layout,
        });
        if (layouts[layoutName]) {
          addDefaultLayout = false;
          layoutArray.unshift(layouts[layoutName].default);
        } else {
          console.warn(`Layout "${layoutName}" not found.`);
        }
        break;
      }
    }

    if (addDefaultLayout) {
      layoutArray.unshift(DefaultLayout as DefineComponent);
    }
  } else {
    layoutArray.unshift(DefaultLayout as DefineComponent);
  }

  // add App.vue as root layout
  layoutArray.unshift(App as DefineComponent);

  return layoutArray;
};

// Instances of i18n and pinia
const i18n = setupI18n();
const pinia = createPinia();

/**
 * Create a ContentStash app
 *
 * @param {ContentStashAppProps} props - The props of the app
 *
 * @returns CreateInertiaAppProps
 */
export const createContentStashApp = (
  props: ContentStashAppProps,
): CreateInertiaAppProps => {
  return defu(props, {
    progress: {
      delay: 250,
      // TODO: Change color to primary color
      color: "#29d",
      includeCSS: true,
      showSpinner: false,
    },
    setup: async ({
      el,
      App,
      props,
      plugin,
    }: Parameters<CreateInertiaAppProps["setup"]>[0]) => {
      const routes = await fetchRoutes();

      createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(pinia)
        .use(ZiggyVue, routes)
        .use(i18n)
        .component("UiDrawerClose", DrawerClose)
        .component("UiDrawerPortal", DrawerPortal)
        .component("UiDrawerTrigger", DrawerTrigger)
        .mount(el);
    },
    resolve: async (name: string) => {
      const pages = getPages(props);
      const page = pages[name];
      page.default.layout = getLayout({
        layouts: getLayouts(props),
        name,
        page,
        pages,
      });

      return page;
    },
  }) as CreateInertiaAppProps;
};

export default {
  createContentStashApp,
};
