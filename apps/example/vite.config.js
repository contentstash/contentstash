import { defineConfig } from "vite";
import { contentStashViteConfig } from "@contentstash/core/vite.config.js";
// import AutoImport from "unplugin-auto-import/vite";
// import path from "path";
// import { fileURLToPath } from "node:url";

const test = contentStashViteConfig({
  // appDir: path.resolve(fileURLToPath(import.meta.url), ".."),
  plugins: [
    // AutoImport({
    //   dirs: ["resources/ts/composables"],
    //   dts: path.resolve(
    //     fileURLToPath(import.meta.url),
    //     "../resources/ts/types/auto-imports.d.ts",
    //   ),
    // }),
  ],
});

console.log(test);

export default defineConfig(test);
