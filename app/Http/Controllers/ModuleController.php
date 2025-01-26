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
        public ModuleRepository $moduleRepository,
        public ModuleService $moduleService,
    ) {
    }

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
        $zipFile = $this->moduleService->generateModuleZipped($module);

        return response()->download($zipFile)->deleteFileAfterSend();
    }
}
