import { defu } from "defu";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath, URL } from "node:url";

/**
 * ContentStash Vite Config
 *
 * @param config {import('vite').UserConfig}
 * @returns {import('vite').UserConfig}
 */
export const contentStashViteConfig = (config) => {
  return defu(
    {
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
            "vendor/contentstash/core/resources/ts/app.ts",
          ],
          refresh: true,
        }),
      ],
      resolve: {
        alias: {
          "@": fileURLToPath(new URL("./resources/ts", import.meta.url)),
        },
      },
    },
    config,
  );
};

export default {
  contentStashViteConfig,
};
