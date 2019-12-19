const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");
const autoprefixer = require("autoprefixer");
require("laravel-mix-purgecss");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    output: { chunkFilename: "js/[name].[contenthash].js" },
    resolve: {
        alias: {
            vue$: "vue/dist/vue.runtime.js",
            "@": path.resolve("resources/js")
        }
    }
})
    .js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .options({
        processCssUrls: false,
        postCss: [tailwindcss("./tailwind.config.js"), autoprefixer]
    });

if (!mix.inProduction()) {
    mix.sourceMaps();
}
if (mix.inProduction()) {
    mix.purgeCss({}).version();
}
