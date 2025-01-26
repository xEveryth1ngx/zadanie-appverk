<?php

namespace App\Respositories;

use App\DTOs\ModuleDTO;
use App\Models\Module;

class ModuleRepository
{
    // I'm a big fan of using DTO + Repository pattern in Laravel,
    // but this could also be done passing Module specific request for example.
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
