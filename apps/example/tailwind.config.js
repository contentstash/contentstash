import defaultTheme from "tailwindcss/defaultTheme";

import { contentStashTailwindConfig } from "@contentstash/core/tailwind.config.js";

/** @type {import('tailwindcss').Config} */
export default contentStashTailwindConfig({
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/**/*.blade.php",
    "./resources/**/*.ts",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Figtree", ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [],
});
