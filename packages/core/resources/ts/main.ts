// import { DefineComponent, Plugin, App as VueApp } from 'vue';
// import { Page, PageProps } from '@inertiajs/core';
// import { DefineComponent, Plugin } from 'vue';
// interface InertiaAppProps {
//     initialPage: Page;
//     initialComponent?: object;
//     resolveComponent?: (name: string) => DefineComponent | Promise<DefineComponent>;
//     titleCallback?: (title: string) => string;
//     onHeadUpdate?: (elements: string[]) => void;
// }
// type InertiaApp = DefineComponent<InertiaAppProps>;
// declare const App: InertiaApp;
import { createApp, h } from "vue";

import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// interface CreateInertiaAppProps {
//     id?: string;
//     resolve: (name: string) => DefineComponent | Promise<DefineComponent> | {
//         default: DefineComponent;
//     };
//     setup: (props: {
//         el: Element;
//         App: InertiaApp;
//         props: InertiaAppProps;
//         plugin: Plugin;
//     }) => void | VueApp;
//     title?: (title: string) => string;
//     progress?: false | {
//         delay?: number;
//         color?: string;
//         includeCSS?: boolean;
//         showSpinner?: boolean;
//     };
//     page?: Page;
//     render?: (app: VueApp) => Promise<string>;
// }

export const laravelInput = ["vendor/contentstash/core/resources/js/app.js"];

export const inertiaPagePath = [
  "./Pages/**/*.vue",
  "./../../vendor/contentstash/core/resources/js/Pages/**/*.vue",
];

// export const createContentStashApp = (): CreateInertiaAppProps => {
//     return {
//         resolve: name => {
//             console.info('name', name)

//             const appPages = import.meta.glob('./Pages/**/*.vue',  { eager: true })
//             const corePages = import.meta.glob('./../../vendor/contentstash/core/resources/js/Pages/**/*.vue',  { eager: true })

//             const pages = { };
//             const addPages = (sourcePages, basePath) =>
//                 Object.entries(sourcePages).forEach(([path, component]) => {
//                     pages[path.replace(basePath, '').replace('.vue', '')] = component;
//                 });

//             addPages(corePages, './../../vendor/contentstash/core/resources/js/Pages/');
//             addPages(appPages, './Pages/');

//             // const pages = import.meta.globEager('./Pages/**/*.vue')
//             // const

//             console.info('pages', pages)

//             if(pages[name]) {
//             return pages[name]
//             } else {
//                 throw new Error(`Component ${name} not found`)
//             }
//         },
//         setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .mount(el)
//     },
// };
// }

export const createContentStashApp = (params: any) => {
  console.info("params", params);
  return {
    setup: ({ el, App, props, plugin }: any) => {
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

      // const pages = { };
      // const addPages = (sourcePages, basePath) =>
      //     Object.entries(sourcePages).forEach(([path, component]) => {
      //         pages[path.replace(basePath, '').replace('.vue', '')] = component;
      //     });

      // addPages(corePages, './../../vendor/contentstash/core/resources/js/Pages/');
      // addPages(appPages, './Pages/');

      // console.info('pages', pages)

      // console.info('pages', pages)
      // return pages[name.replace('Pages/', '').replace('.vue', '').replace('pages/', '.')]

      // return params.resolve(name);

      // vite skip import analysis
      const appPages = params.addPages;
      const corePages = params.corePages;

      const pages: Record<string, any> = {};
      const addPages = (sourcePages: any, basePath: any) => {
        // check if sourcePages is an object
        if (typeof sourcePages !== "object") {
          console.info("sourcePages", sourcePages);
          return;
        }

        return Object.entries(sourcePages).forEach(
          ([path, component]: [string, any]) => {
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

      // const pages = import.meta.globEager('./Pages/**/*.vue')
      // const

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
