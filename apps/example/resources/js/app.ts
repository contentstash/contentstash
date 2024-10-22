import "./bootstrap";

// import { createApp, h } from "vue";

import { createInertiaApp } from "@inertiajs/vue3";
import { createContentStashApp } from "@contentstash/core";
// import { inertiaPagePath } from '@contentstash/imports';

// createInertiaApp({
//     resolve: name => {
//         console.info('name', name)
//
//         const appPages = import.meta.glob('./Pages/**/*.vue',  { eager: true })
//         const corePages = import.meta.glob('./../../vendor/contentstash/core/resources/js/Pages/**/*.vue',  { eager: true })
//
//
//         const pages = { };
//         const addPages = (sourcePages, basePath) =>
//             Object.entries(sourcePages).forEach(([path, component]) => {
//                 pages[path.replace(basePath, '').replace('.vue', '')] = component;
//             });
//
//         addPages(corePages, './../../vendor/contentstash/core/resources/js/Pages/');
//         addPages(appPages, './Pages/');
//
//
//
//         // const pages = import.meta.globEager('./Pages/**/*.vue')
//         // const
//
//         console.info('pages', pages)
//         return pages[name]
//     },
//     setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .mount(el)
//     },
// })

const appPages = import.meta.glob("./Pages/**/*.vue", { eager: true });
const corePages = import.meta.glob(
  "./../../vendor/contentstash/core/resources/js/Pages/**/*.vue",
  { eager: true },
);

console.info("appPages", appPages);
console.info("corePages", corePages);

createInertiaApp(
  createContentStashApp({
    appPages,
    corePages,
    // resolve: name => {
    //     console.info('name', name)
    //
    //     const appPages = import.meta.glob('./Pages/**/*.vue',  { eager: true })
    //     const corePages = import.meta.glob('./../../vendor/contentstash/core/resources/js/Pages/**/*.vue',  { eager: true })
    //
    //
    //     const pages = { };
    //     const addPages = (sourcePages, basePath) =>
    //         Object.entries(sourcePages).forEach(([path, component]) => {
    //             pages[path.replace(basePath, '').replace('.vue', '')] = component;
    //         });
    //
    //     addPages(corePages, './../../vendor/contentstash/core/resources/js/Pages/');
    //     addPages(appPages, './Pages/');
    //
    //
    //
    //     // const pages = import.meta.globEager('./Pages/**/*.vue')
    //     // const
    //
    //     console.info('pages', pages)
    //     return pages[name]
    // },
  }),
);
