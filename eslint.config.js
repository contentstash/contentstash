import eslintPluginPrettierRecommended from "eslint-plugin-prettier/recommended";
import globals from "globals";
import pluginJs from "@eslint/js";
import pluginVue from "eslint-plugin-vue";
import tseslint from "typescript-eslint";

export default [
  {
    ignores: [
      "node_modules",
      "vendor",
      "dist",
      "**/node_modules/**",
      "**/vendor/**",
      "**/dist/**",
      "**/public/**",
      "**/.nuxt/**",
    ],
  },
  {
    files: ["**/*.{js,mjs,cjs,ts,vue}"],
  },
  {
    languageOptions: {
      globals: {
        ...globals.browser,
        process: true,
      },
    },
  },
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
      "packages/core/resources/ts/components/ui/auto-form/*.vue",
      "packages/core/resources/ts/components/ui/auto-form/*.ts",
    ],
    rules: {
      "@typescript-eslint/no-explicit-any": "off",
      "@typescript-eslint/no-unused-vars": "off",
    },
  },
  {
    files: [
      "**/resources/ts/pages/**/*.vue",
      "**/resources/ts/components/**/*.vue",
    ],
    rules: {
      "vue/multi-word-component-names": "off",
      "@typescript-eslint/no-unused-vars": "off",
    },
  },
  {
    files: [
      "packages/core/resources/ts/types/auto-imports.d.ts",
      "packages/core/resources/ts/types/components.d.ts",
    ],
    rules: {},
  },
  {
    files: ["**/*.{ts,vue}"],
    rules: {
      // See: https://github.com/unplugin/unplugin-auto-import?tab=readme-ov-file#eslint
      "no-undef": "off",
    },
  },
  eslintPluginPrettierRecommended,
];
