import { defineConfig } from 'vite'
import { resolve } from 'path'
import dts from 'vite-plugin-dts';


// https://vitejs.dev/config/
export default defineConfig({
    build: {
        outDir: 'dist',
        lib: {
            entry: resolve(__dirname, 'src/main.ts'),
            name: '@contentstash/imports',
            fileName: (format) => `main.${format}.js`,
            formats: ['es']
        },
        rollupOptions: {
            external: [],
            output: {
                globals: {},
                exports: 'named'
            },
        },
    },
    resolve: { alias: { src: resolve('src/') } },
    plugins: [
        dts({
            insertTypesEntry: true,
            outDir: 'dist'
        })
    ]
})