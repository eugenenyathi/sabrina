/** @type {import('tailwindcss').Config} */
export default {
    daisyui: {
        themes: ["light", "dark", "cupcake"],
    },
    content: [
        // You will probably also need these lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                scarlet: "rgb(255 45 31)", // Reddish orange
            },
        },
    },

    // Add daisyUI
    plugins: [require("daisyui")],
};
