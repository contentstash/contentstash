import { defineConfig } from 'taze';

export default defineConfig({
    force: true,
    recursive: true,
    exclude: [],
    ignorePaths: ['packages/**/vendor'],
});