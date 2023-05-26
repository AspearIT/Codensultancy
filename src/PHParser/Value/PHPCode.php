<?php

namespace AspearIT\Codensultancy\PHParser\Value;

use AspearIT\Codensultancy\PHParser\Exception\PHPCodeUnitTypeException;

class PHPCode
{
    public function __construct(
        private readonly PHPCodeType $unitType,
        private readonly string      $originalCode,
    ) {}

    public function shouldBeTypeOf(string $class): void
    {
        if (!$this->unitType instanceof $class) {
            throw PHPCodeUnitTypeException::forWrongUnitTypeGiven($class, $this->unitType);
        }
    }

    public function getUnitType(): PHPCodeType
    {
        return $this->unitType;
    }

    public function getOriginalCode(): string
    {
        return $this->originalCode;
    }
}