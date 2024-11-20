/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                customPurple: "#7b4f79",
                purple2: "#975e94",
                purple3: "#b596b3",
            },
        },
    },
    plugins: [],
};
