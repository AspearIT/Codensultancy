<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Import implements PHPCodeType
{
    public function __construct(private readonly array $classParts) {}

    public function getClassName(): string
    {
        return implode('\\', $this->classParts);
    }

    public function getInnerCode(): array
    {
        return [];
    }
}