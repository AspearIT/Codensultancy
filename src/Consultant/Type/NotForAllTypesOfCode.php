<?php

namespace AspearIT\Codensultancy\Consultant\Type;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;

abstract class NotForAllTypesOfCode implements ConsultantInterface
{
    final public function consult(PHPCode $PHPContent, CodeType $codeType): array
    {
        if (in_array($codeType, $this->getExcludedCodeTypes())) {
            return [];
        }
        return $this->consultForOtherCodeTypes($PHPContent, $codeType);
    }

    /**
     * @return CodeType[]
     */
    abstract protected function getExcludedCodeTypes(): array;

    abstract protected function consultForOtherCodeTypes(PHPCode $PHPContent, CodeType $codeType): array;
}