import "./bootstrap";

import { createContentStashApp } from "@contentstash/core";
import { createInertiaApp } from "@inertiajs/vue3";

await createInertiaApp(
  createContentStashApp({
    // layouts: import.meta.glob("./layouts/*.vue", { eager: true }),
    pages: import.meta.glob("./pages/**/*.vue", { eager: true }),
  }),
);
