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
    public function getInnerCode(): array
    {
        return $this->unitType->getInnerCode();
    }

    /**
     * @return self[]
     */
    public function getInnerCodeRecursive(): array
    {
        $result = [];
        foreach ($this->unitType->getInnerCode() as $codeSubUnit) {
            // Ignore the collections because they have no value in this context
            if (!$codeSubUnit->unitType instanceof CodeCollection) {
                $result[] = $codeSubUnit;
            }
            $result = array_merge($result, $codeSubUnit->getInnerCodeRecursive());
        }
        return $result;
    }

    /**
     * @return PHPCode[]
     */
    public function getInnerCodeFromType(string $codeTypeClassName): array
    {
        $result = [];
        foreach ($this->getInnerCodeRecursive() as $code) {
            if ($code->getUnitType() instanceof $codeTypeClassName) {
                $result[] = $code;
            }
        }
        return $result;
    }
}