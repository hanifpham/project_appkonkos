import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "0.0.0.0", // Izinkan akses dari semua IP
        hmr: {
            host: "10.157.145.14", // Ganti dengan IP Laptop Anda (Cek pakai ipconfig)
        },
    },
});
