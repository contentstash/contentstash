import { defineConfig } from 'vite'
// import dts from 'vite-plugin-dts';
import { resolve } from 'path'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
    // build: {
    //     outDir: 'dist',
    //     lib: {
    //         entry: resolve(__dirname, 'src/main.ts'),
    //         name: '@contentstash/imports',
    //         fileName: (format) => `main.${format}.js`,
    //         formats: ['es', 'cjs', 'umd']
    //     },
    //     rollupOptions: {
    //         external: [],
    //         output: {
    //             globals: {},
    //             exports: 'named'
    //         },
    //     },
    // },
    resolve: { alias: { src: resolve('src/') } },
    plugins: [
        // dts({
        //     insertTypesEntry: true,
        //     outDir: 'dist'
        // }),
        vue()
    ]
})