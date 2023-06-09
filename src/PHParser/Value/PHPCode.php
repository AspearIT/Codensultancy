<?php

namespace AspearIT\Codensultancy\PHParser\Value;

use AspearIT\Codensultancy\PHParser\Exception\PHPCodeUnitTypeException;
use \BadMethodCallException;

class PHPCode
{
    public function __construct(
        private readonly PHPCodeType $codeType,
        private readonly string      $originalCode,
        private readonly int         $lineFrom,
        private readonly int         $lineTo,
    ) {}

    public function shouldBeTypeOf(string $class): void
    {
        if (!$this->codeType instanceof $class) {
            throw PHPCodeUnitTypeException::forWrongUnitTypeGiven($class, $this->codeType);
        }
    }

    public function getCodeType(): PHPCodeType
    {
        return $this->codeType;
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
        return $this->codeType->getInnerCode();
    }

    /**
     * @return self[]
     */
    public function getInnerCodeRecursive(): array
    {
        $result = [];
        foreach ($this->codeType->getInnerCode() as $codeSubUnit) {
            // Ignore the collections because they have no value in this context
            if (!$codeSubUnit->codeType instanceof CodeCollection) {
                $result[] = $codeSubUnit;
            }
            $result = array_merge($result, $codeSubUnit->getInnerCodeRecursive());
        }
        return $result;
    }

    /**
     * @return PHPCode[]
     */
    public function getCodeFromType(string $codeTypeClassName): array
    {
        $result = [];
        if ($this->getCodeType() instanceof $codeTypeClassName) {
            $result[] = $this;
        }
        foreach ($this->getInnerCode() as $code) {
            $result = array_merge($result, $code->getCodeFromType($codeTypeClassName));
        }
        return $result;
    }
}