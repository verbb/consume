import { resolve } from 'node:path';

import { defineConfig } from 'vite';

const root = resolve(import.meta.dirname, 'src/web/assets/cp');

export default defineConfig({
    root,
    // CP bundles publish under Craft's cpresources, so a relative base keeps shared chunks beside their entry.
    base: '',
    build: {
        outDir: resolve(root, 'dist'),
        emptyOutDir: true,
        assetsDir: '',
        cssMinify: 'esbuild',
        cssTarget: ['chrome61', 'safari10'],
        rolldownOptions: {
            input: {
                consume: resolve(root, 'src/consume.css'),
                // Plugin Kit only loads on the pages that show one of its components.
                'plugin-kit': resolve(root, 'src/plugin-kit.js'),
            },
            output: {
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name][extname]',
            },
        },
    },
    resolve: {
        // Plugin Kit is linked from its checkout, so resolve Lit from one place to bundle a single copy.
        dedupe: ['lit'],
    },
});
