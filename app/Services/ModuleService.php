<?php

namespace App\Services;

use App\Models\Module;
use App\Utils\ModuleGenerator;

class ModuleService
{
    public function __construct(
        private readonly ModuleGenerator $moduleGenerator,
    ) {
    }

    public function generateModuleZipped(Module $module)
    {
        $tempFolder = storage_path('public/temp');
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0755, true);
        }

        $htmlFile = $tempFolder . '/index.html';
        $cssFile = $tempFolder . '/styles.css';
        $jsFile = $tempFolder . '/script.js';
        $zipFile = storage_path('public/files.zip');

        file_put_contents($htmlFile, $this->moduleGenerator->generateHtmlFile($module));
        file_put_contents($cssFile, $this->moduleGenerator->generateCssFile($module));
        file_put_contents($jsFile, $this->moduleGenerator->generateJsFile($module));

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
