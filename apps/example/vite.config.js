import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
// import { laravelInput } from '@contentstash/imports';

export default defineConfig({
  plugins: [
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    laravel({
      input: [
        "resources/css/app.css",
        "vendor/contentstash/core/resources/js/app.ts",
      ],
      refresh: true,
    }),
  ],
});
