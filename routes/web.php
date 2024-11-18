<?php

use Illuminate\Support\Facades\Route;
use Enhance\Enhancer;
use Enhance\Elements;
use Enhance\ShadyStyles;
use Enhance\EnhanceWASM;

Route::get('/', function () {

    $elementPath = __DIR__ . "/../resources/js/components";
    $elements = new Elements($elementPath);
    $scopeMyStyle = new ShadyStyles();
    $enhance = new Enhancer([
        "elements" => $elements,
        "initialState" => [],
        "styleTransforms" => [[$scopeMyStyle, "styleTransform"]],
        "enhancedAttr" => true,
        "bodyContent" => false,
    ]);

    $htmlString = <<<HTMLDOC
        <!DOCTYPE html>
            <html>
            <head>
            </head>
            <body>
                <my-header><h1>Hello World</h1></my-header>
            </body>
            </html>
    HTMLDOC;

    $output = $enhance->ssr($htmlString);

    echo $output;
    // return view('welcome');
});

Route::get('/wasm', function () {

    $elementPath = "../resources/js/components";
    $elements = new Elements($elementPath, ["wasm" => true]);
    $enhance = new EnhanceWASM(["elements" => $elements->wasmElements]);

    $input = [
        "markup" => "<my-header>Hello World</my-header>",
        "initialState" => [],
    ];

    $output = $enhance->ssr($input);

    $htmlDocument = $output->document;

    echo $htmlDocument . "\n";
});

Route::get('/card', function () {
    $elementPath = "../resources/js/components";
    $elements = new Elements($elementPath, ["wasm" => true]);


    $strip = function ($content) {
        $content = preg_replace('/customElements\.define\([^)]+\)\s*;?\s*/', '', $content);

        $content = preg_replace('/extends\s+CustomElement/', '', $content);
        $content = preg_replace('/import\s+\w+\s+from\s+["\'][^"\']+["\'];?\s*/', '', $content);
        $content = preg_replace('/export\s+default\s+/', '', $content);

        return $content;
    };

    $wasmElements = [];

    $copy_1 = $elements->wasmElements;

    // loop through the elements and strip the export and custom element define statements
    foreach ($elements->wasmElements as $key => $element) {
        $wasmElements[$key] = $strip($element);
    }

    // $enhance = new EnhanceWASM(["elements" => $elements->wasmElements]);
    $enhance = new EnhanceWASM(["elements" => $wasmElements]);

    $view = view('card-example')->render();

    $preprocessor = function ($content) {
        $content = preg_replace('/customElements\.define\([^)]+\)\s*;?\s*/', '', $content);
        $content = preg_replace('/export\s+default\s+\w+\s*;?\s*/', '', $content);
        return $content;
    };


    $output = $enhance->ssr([
        "markup" => $view,
        "initialState" => [],
    ]);

    echo $output->document . "\n";
});