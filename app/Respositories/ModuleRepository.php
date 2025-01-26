<?php

namespace App\Respositories;

use App\DTOs\ModuleDTO;
use App\Models\Module;

class ModuleRepository
{
    public function createModule(ModuleDTO $module): ?Module
    {
        return Module::create([
            'width' => $module->width,
            'height' => $module->height,
            'color' => $module->color,
            'link' => $module->link,
        ]);
    }
}
