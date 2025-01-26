<?php

namespace App\DTOs;


use Illuminate\Http\Request;

class ModuleDTO
{
    public function __construct(
        public readonly int $width,
        public readonly int $height,
        public readonly string $color,
        public readonly string $link,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $data = $request->validated();

        return new self(
            width: $data['width'],
            height: $data['height'],
            color: $data['color'],
            link: $data['link'],
        );
    }
}
