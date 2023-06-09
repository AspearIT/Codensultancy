<?php

namespace AspearIT\Codensultancy\PHParser\Value;

readonly class ObjectCreation implements PHPCodeType
{
    public function __construct(
        private string $className,
        private array $inputArgs,
    ) {}

    public function getInnerCode(): array
    {
        return $this->inputArgs;
    }
}