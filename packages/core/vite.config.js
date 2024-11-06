import { URL, fileURLToPath } from "node:url";

import AutoImport from "unplugin-auto-import/vite";
import Components from "unplugin-vue-components/vite";
import { defu } from "defu";
import laravel from "laravel-vite-plugin";
import path from "path";
import vue from "@vitejs/plugin-vue";
// import vueI18n from "@intlify/unplugin-vue-i18n/vite";

export const definePagePlugin = () => {
  return {
    name: "define-page-plugin",
    transform(code, id) {
      // skip non-vue files
      if (!id.endsWith(".vue")) {
        return;
      }

      const updatedCode = code.replace(/definePage/g, "defineOptions");

      return {
        code: updatedCode,
        map: null,
      };
    },
  };
};

/**
 * ContentStash Vite Config
 *
 * @param config {Partial<import('vite').UserConfig & {
 *   contentStash: {
 *     appDir: string
 *   }
 * }>}
 * @returns {import('vite').UserConfig}
 */
export const contentStashViteConfig = (config) => {
  const appDir = config?.contentStash?.appDir ?? process.cwd();

  return defu(config, {
    build: {
      target: "ESNEXT",
    },
    plugins: [
      definePagePlugin(),
      vue({
        template: {
          transformAssetUrls: {
            base: null,
            includeAbsolute: false,
          },
        },
      }),
      // vueI18n({
      //   include: [
      //     "./vendor/contentstash/core/resources/ts/locales/**/*.json",
      //     path.resolve(appDir, "resources/ts/locales/**/*.json"),
      //   ],
      // }),
      laravel({
        input: [
          "resources/css/app.css",
          "resources/ts/app.ts",
          "vendor/contentstash/core/resources/ts/main.ts",
        ],
        refresh: true,
      }),
      Components({
        dirs: [
          "vendor/contentstash/core/resources/ts/components",
          path.resolve(appDir, "resources/ts/components"),
          "vendor/contentstash/core/resources/ts/layouts",
          path.resolve(appDir, "resources/ts/layouts"),
        ],
        // resolvers: [
        //   (name) => {
        //     // if (name === 'MyCustom')
        //     //   return path.resolve(__dirname, 'src/CustomResolved.vue').replaceAll('\\', '/')
        //     console.info("name", name);
        //   },
        //     ],
        allowOverrides: true,
        directoryAsNamespace: true,
        collapseSamePrefixes: true,
        dts: path.resolve(
          fileURLToPath(import.meta.url),
          "../resources/ts/types/components.d.ts",
        ),
      }),
      AutoImport({
        imports: [
          "vue",
          {
            vue: [
              ["defineOptions"],
              // ['defineOptions', "definePage"],
            ],
          },
        ],
        dirs: [
          "vendor/contentstash/core/resources/ts/composables",
          path.resolve(appDir, "resources/ts/composables"),
        ],
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
  });
};

export default {
  contentStashViteConfig,
};
