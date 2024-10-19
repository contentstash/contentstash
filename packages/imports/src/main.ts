// import { DefineComponent, Plugin, App as VueApp } from 'vue';
// import { Page, PageProps } from '@inertiajs/core';
// import { DefineComponent, Plugin } from 'vue';
// export interface InertiaAppProps {
//     initialPage: Page;
//     initialComponent?: object;
//     resolveComponent?: (name: string) => DefineComponent | Promise<DefineComponent>;
//     titleCallback?: (title: string) => string;
//     onHeadUpdate?: (elements: string[]) => void;
// }
// export type InertiaApp = DefineComponent<InertiaAppProps>;
// declare const App: InertiaApp;
// import { createApp, h } from 'vue'
//
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

export const laravelInput = [
    'vendor/contentstash/core/resources/js/app.js'
];

export const inertiaPagePath = [
    './Pages/**/*.vue',
    './../../vendor/contentstash/core/resources/js/Pages/**/*.vue'
];


// export const createContentStashApp = (params: CreateInertiaAppProps): CreateInertiaAppProps => {
//     return {
//         resolve: name => {
//             console.info('name', name)
//             const pages = import.meta.glob([
//                     './Pages/**/*.vue',
//                     './../../vendor/contentstash/core/resources/js/Pages/**/*.vue'
//                 ],
//                 { eager: true })
//             return pages[`./Pages/${name}.vue`]
//         },
//         setup({ el, App, props, plugin }) {
//             createApp({ render: () => h(App, props) })
//                 .use(plugin)
//                 .mount(el)
//         },
//         ...params
//     };
// }


export default {
    laravelInput,
    inertiaPagePath,
    // createContentStashApp
}
