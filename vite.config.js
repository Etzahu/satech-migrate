import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/order-pdf.css",
                "resources/css/app.css",
                "resources/css/home.css",
                "resources/js/app.js",
                "resources/js/video-player.js",
                "resources/js/flow-diagram.js",
                "resources/js/progress-approval.js",
                "resources/css/filament/admin/theme.css",
            ],
            refresh: true,
        }),
    ],
});
