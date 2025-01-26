<?php

namespace App\Http\Controllers;

use App\DTOs\ModuleDTO;
use App\Exceptions\ModuleNotFoundException;
use App\Http\Requests\ModuleStoreRequest;
use App\Models\Module;
use App\Respositories\ModuleRepository;
use App\Services\ModuleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ModuleController extends Controller
{
    public function __construct(
        public readonly ModuleRepository $moduleRepository,
        public readonly ModuleService $moduleService,
    ) {
    }

    public function store(ModuleStoreRequest $request): JsonResponse
    {
        $module = $this->moduleRepository->createModule(ModuleDTO::fromRequest($request));

        if (!$module) {
            return response()->json(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'id' => $module->id,
        ], status: Response::HTTP_CREATED);
    }

    // Instead of generating the module for each request, it could be cached,
    // files could be stored in some sort of storage (like S3 bucket) or even
    // queued.
    public function download(Module $module)
    {
        $zipFile = $this->moduleService->generateModuleZipped($module);

        return response()->download($zipFile)->deleteFileAfterSend();
    }
}
