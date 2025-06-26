import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: ["resources/views/**/*"],
        }),
        tailwindcss(),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
    },
    server: {
        host: "0.0.0.0", // Đảm bảo Railway/Render có thể truy cập
        port: 5173,
        cors: true,
    },
});
