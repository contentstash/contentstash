import globals from "globals";
import pluginJs from "@eslint/js";
import tseslint from "typescript-eslint";
import pluginVue from "eslint-plugin-vue";
import eslintPluginPrettierRecommended from "eslint-plugin-prettier/recommended";

export default [
  {
    ignores: [
      "node_modules",
      "vendor",
      "dist",
      "**/node_modules/**",
      "**/vendor/**",
      "**/dist/**",
    ],
  },
  { files: ["**/*.{js,mjs,cjs,ts,vue}"] },
  { languageOptions: { globals: globals.browser } },
  pluginJs.configs.recommended,
  ...tseslint.configs.recommended,
  ...pluginVue.configs["flat/essential"],
  {
    files: ["**/*.vue"],
    languageOptions: { parserOptions: { parser: tseslint.parser } },
    rules: {
      "vue/component-tags-order": [
        "error",
        {
          order: [
            "script:not([setup])",
            "script[setup]",
            "template",
            "style:not([scoped])",
            "style[scoped]",
          ],
        },
      ],
    },
  },
  {
    files: [
      "**/resources/ts/pages/**/*.vue",
      "**/resources/ts/components/ui/**/*.vue",
    ],
    rules: {
      "vue/multi-word-component-names": "off",
      "@typescript-eslint/no-unused-vars": [
        "warn",
        {
          argsIgnorePattern: "^_",
          varsIgnorePattern: "^_",
        },
      ],
    },
  },
  {
    files: ["packages/core/resources/ts/types/auto-imports.d.ts"],
    rules: {},
  },
  eslintPluginPrettierRecommended,
];
