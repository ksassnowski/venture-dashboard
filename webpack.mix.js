const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

mix.setPublicPath("public")
    .postCss("resources/css/app.css", "public")
    .options({
        postCss: [tailwindcss("./tailwind.config.js")],
    })
    .js("resources/js/app.js", "public")
    .webpackConfig(require("./webpack.config.js"))
    .version()
    .copy("resources/img", "public/img");
