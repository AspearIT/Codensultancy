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

    /**
     * @return self[]
     */
    public function getSubCodeUnits(): array
    {
        return $this->unitType->getCodeSubUnits();
    }

    /**
     * @return self[]
     */
    public function getSubCodeUnitsRecursive(): array
    {
        $result = [];
        foreach ($this->unitType->getCodeSubUnits() as $codeSubUnit) {
            // Ignore the collections because they have no value in this context
            if (!$codeSubUnit->unitType instanceof CodeCollection) {
                $result[] = $codeSubUnit;
            }
            $result = array_merge($result, $codeSubUnit->getSubCodeUnitsRecursive());
        }
        return $result;
    }
}