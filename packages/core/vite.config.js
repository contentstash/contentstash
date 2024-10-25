import { defu } from "defu";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath, URL } from "node:url";
import path from "path";
import Components from "unplugin-vue-components/vite";

/**
 * ContentStash Vite Config
 *
 * @param config {import('vite').UserConfig}
 * @returns {import('vite').UserConfig}
 */
export const contentStashViteConfig = (config) => {
  return defu(
    {
      build: {
        target: 'ESNEXT',
      },
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
            "resources/ts/app.ts",
            "vendor/contentstash/core/resources/ts/main.ts",
          ],
          refresh: true,
        }),
        Components({
          dirs: ["vendor/contentstash/core/resources/ts/components"],
          directoryAsNamespace: true,
          collapseSamePrefixes: true,
          dts: path.resolve(
            fileURLToPath(import.meta.url),
            "../resources/ts/types/auto-imports.d.ts",
          ),
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
