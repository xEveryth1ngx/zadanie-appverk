<?php

namespace App\Utils;

use App\Models\Module;

class ModuleGenerator
{
    public function generateHtmlFile(Module $module): string
    {
        return "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Generated HTML</title>
                <link rel='stylesheet' href='styles.css'>
            </head>
            <body>
                <div id='link-handle_1'>Hello, click me!</div>
                <script src='script.js'></script>
            </body>
            </html>
        ";
    }

    public function generateCssFile(Module $module): string
    {
        return "
            #link-handle_1 {
                background-color: " . $module->color . ";
                width: " . $module->width . "rem;
                height: " . $module->height . "rem;
                cursor: pointer;
            }
        ";
    }

    public function generateJsFile(Module $module): string
    {
        return "
            document.querySelector('#link-handle_1').addEventListener('click', () => {
                window.open('" . $module->link . "');
            });
        ";
    }
}
