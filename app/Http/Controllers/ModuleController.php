<?php

namespace App\Http\Controllers;

use App\DTOs\ModuleDTO;
use App\Exceptions\ModuleNotFoundException;
use App\Http\Requests\ModuleStoreRequest;
use App\Models\Module;
use App\Respositories\ModuleRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ModuleController extends Controller
{
    public function __construct(
        public ModuleRepository $moduleRepository,
    ) {
    }

    /**
     * @param ModuleStoreRequest $request
     * @return JsonResponse
     * @throws ModuleNotFoundException
     */
    public function store(ModuleStoreRequest $request): JsonResponse
    {
        $module = $this->moduleRepository->createModule(ModuleDTO::fromRequest($request));

        if (!$module) {
            try {
                throw new ModuleNotFoundException();
            } catch (ModuleNotFoundException $e) {
                return response()->json(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return response()->json([
            'id' => $module->id,
        ], status: Response::HTTP_CREATED);
    }

    public function download(Module $module)
    {
        // Define file content
        $htmlContent = "<!DOCTYPE html>
<html>
<head>
    <title>Generated HTML</title>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
    <div id='link-handle_1'>Hello, click me!</div>
    <script src='script.js'></script>
</body>
</html>";

        $cssContent = "#link-handle_1 {
    background-color: " . $module->color . ";
    width: " . $module->width . "rem;
    height: " . $module->height . "rem;
    cursor: pointer;
}";

        $jsContent = "document.querySelector('#link-handle_1').addEventListener('click', () => {
    window.open('" . $module->link . "');
});";

        // Temporary folder to store files
        $tempFolder = storage_path('public/temp');
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0755, true);
        }

        // File paths
        $htmlFile = $tempFolder . '/index.html';
        $cssFile = $tempFolder . '/styles.css';
        $jsFile = $tempFolder . '/script.js';
        $zipFile = storage_path('public/files.zip');

        // Write files
        file_put_contents($htmlFile, $htmlContent);
        file_put_contents($cssFile, $cssContent);
        file_put_contents($jsFile, $jsContent);

        // Create a ZIP file
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $zip->addFile($htmlFile, 'index.html');
            $zip->addFile($cssFile, 'styles.css');
            $zip->addFile($jsFile, 'script.js');
            $zip->close();
        }

        // Clean up individual files
        unlink($htmlFile);
        unlink($cssFile);
        unlink($jsFile);

        // Return the zip file as a download
        return response()->download($zipFile)->deleteFileAfterSend();
    }
}
