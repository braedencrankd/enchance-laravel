# Laravel Enchance SSR experiment

This is a brief exploration of using SSR web components in a laravel project. You can find the experiments by going to the `routes/web.php` file.
I used DDEV for this project as it was the easiest way to setup the correct php environment to get WASM working.

## To get started

1. Install (DDEV)[https://ddev.readthedocs.io/en/latest/users/install/docker-installation/] for an easy docker based setup.
2. Clone this repo `git clone https://github.com/braedencrankd/enchance-laravel.git`
3. Then `cd enhance-laravel`
4. Run `ddev start`
5. Run `ddev composer install`
6. Run `ddev npm install`
7. Run `ddev php artisan key:generate`
8. Run `ddev launch`

### To get the WASM building working I needed to make the following updates.

1. Go to `vendor/enhance-dev/src/EnhanceWASM.php` and change the use statement for PathWasmSource from `use Extism\PathWasmSource;` to `use Extism\Manifest\PathWasmSource;`
2. Now run `mkdir -p vendor/enhance/ssr-wasm && cd \"$_\" && curl -L https://github.com/enhance-dev/enhance-ssr-wasm/releases/download/v0.0.4/enhance-ssr.wasm.gz | gunzip > enhance-ssr.wasm` Make sure not to run this in ddev as it won't be able to pull the resource correctly.
3. That should be it, hopefully this helps someone explore further in the future.
