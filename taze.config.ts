import { defineConfig } from "taze";

export default defineConfig({
  force: true,
  recursive: true,
  exclude: [],
  ignorePaths: ["apps/**/vendor", "packages/**/vendor"],
});
