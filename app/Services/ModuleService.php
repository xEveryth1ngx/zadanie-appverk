<?php

namespace App\Services;

use App\Models\Module;
use App\Utils\ModuleGenerator;
use Illuminate\Support\Str;

class ModuleService
{
    public function generateModuleZipped(Module $module)
    {
        $tempFolder = storage_path('app/temp');
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0755, true);
        }

        $hash = Str::random(10);

        $htmlFile = $tempFolder . '/index' . $hash . '.html';
        $cssFile = $tempFolder . '/styles' . $hash . '.css';
        $jsFile = $tempFolder . '/script' . $hash . '.js';
        $zipFile = storage_path("app/temp/files_$hash.zip");

        file_put_contents($htmlFile, ModuleGenerator::generateHtmlFile($module));
        file_put_contents($cssFile, ModuleGenerator::generateCssFile($module));
        file_put_contents($jsFile, ModuleGenerator::generateJsFile($module));

        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $zip->addFile($htmlFile, 'index.html');
            $zip->addFile($cssFile, 'styles.css');
            $zip->addFile($jsFile, 'script.js');
            $zip->close();
        }

        unlink($htmlFile);
        unlink($cssFile);
        unlink($jsFile);

        return $zipFile;
    }
}
