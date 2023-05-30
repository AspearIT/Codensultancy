<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Value implements PHPCodeType
{
    public function __construct(private readonly string $value) {}

    public function getInnerCode(): array
    {
        return [];
    }
}