/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors'); 

module.exports = {
    presets: [
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Livewire/**/*Table.php",
        "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
        "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php",
    ],
    theme: {
        extend: {
            colors: {
                customPurple: "#7b4f79",
                purple2: "#A55BA5",
                purple3: "#b596b3",
                purple4: "#8c5a8b",
                "pg-primary": colors.gray,
            },
        },
    },
    plugins: [],
};
