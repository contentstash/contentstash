import { defu } from "defu";

/**
 * ContentStash Tailwind Config
 *
 * @param config {import('tailwindcss').Config}
 * @returns {import('tailwindcss').Config}
 */
export const contentStashTailwindConfig = (config) => {
    return defu({
        content: [
            './vendor/contentstash/core/resources/js/**/*.vue',
            './vendor/contentstash/core/resources/views/**/*.blade.php',
        ],
        plugins: [],
    }, config);
};

export default {
    contentStashTailwindConfig
}