<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Variable implements PHPCodeType
{
    public function __construct(
        private readonly string $name,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getInnerCode(): array
    {
        return [];
    }
}