<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class PHPCodeUnit
{
    public function __construct(
        private readonly PHPCodeUnitType $unitType,
        private readonly string          $originalCode,
    ) {}

    public function getUnitType(): PHPCodeUnitType
    {
        return $this->unitType;
    }

    public function getOriginalCode(): string
    {
        return $this->originalCode;
    }
}