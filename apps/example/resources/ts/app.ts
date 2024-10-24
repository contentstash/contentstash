import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { createContentStashApp } from "@contentstash/core";

await createInertiaApp(createContentStashApp({}));
