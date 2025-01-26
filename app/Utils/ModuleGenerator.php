<?php

namespace App\Utils;

use App\Models\Module;

// I'm generating files like this for the sake of simplicity,
// in a real world scenario it might be wiser to use a templating engine.
class ModuleGenerator
{
    public static function generateHtmlFile(Module $module): string
    {
        return mb_trim("
            <!DOCTYPE html>
            <html>
            <head>
                <title>Generated HTML</title>
                <link rel='stylesheet' href='styles.css'>
            </head>
            <body>
                <div id='link-handle_" . $module->id . "'>Hello, click me!</div>
                <script src='script.js'></script>
            </body>
            </html>
        ");
    }

    public static function generateCssFile(Module $module): string
    {
        return mb_trim("
            #link-handle_" . $module->id . " {
                background-color: " . $module->color . ";
                width: " . $module->width . "rem;
                height: " . $module->height . "rem;
                cursor: pointer;
            }
        ");
    }

    public static function generateJsFile(Module $module): string
    {
        return mb_trim("
            document.querySelector('#link-handle_" . $module->id . "').addEventListener('click', () => {
                window.open('" . $module->link . "');
            });
        ");
    }
}
