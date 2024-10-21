import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

createInertiaApp({
  resolve: (name) => {
    console.info("name", name);
    const pages = import.meta.glob(
      [
        "./Pages/**/*.vue",
        "./../../vendor/contentstash/core/resources/js/Pages/**/*.vue",
      ],
      { eager: true },
    );
    return pages[`./Pages/${name}.vue`];
    return name;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el);
  },
});
