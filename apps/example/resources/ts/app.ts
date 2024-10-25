import "./bootstrap";

import { createContentStashApp } from "@contentstash/core";
import { createInertiaApp } from "@inertiajs/vue3";

await createInertiaApp(
  createContentStashApp({
    pages: import.meta.glob("./pages/**/*.vue", { eager: true }),
  }),
);
