import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/daftar.css",
                "resources/css/scroll.css",
                "resources/js/app.js",
                "resources/js/bootstrap.js",
                "resources/js/daftar.js",
                "resources/js/dashboard.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: "public/build", // Output directory for production assets
        manifest: true, // Generate a manifest file
    },
});
