import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/ts/app.tsx",
            ssr: "resources/ts/ssr.tsx",
            refresh: ["resources/ts/**", "resources/views/**", "routes/**"],
        }),
        react(),
    ],
    server: {
        hmr: {
            host: "localhost",
        },
        host: true,
    },
    resolve: {
        alias: {
            "@": "/resources/ts",
        },
    },
});
