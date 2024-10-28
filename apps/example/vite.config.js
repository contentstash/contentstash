import { defineConfig } from "vite";
import { contentStashViteConfig } from "@contentstash/core/vite.config.js";

const test = contentStashViteConfig({});

console.log(test);

export default defineConfig(test);
