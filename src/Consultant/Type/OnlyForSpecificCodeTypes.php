<?php

namespace AspearIT\Codensultancy\Consultant\Type;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;

abstract class OnlyForSpecificCodeTypes implements ConsultantInterface
{
    final public function consult(PHPCode $PHPContent, CodeType $codeType): array
    {
        if (!in_array($codeType, $this->getRelevantCodeTypes())) {
            return [];
        }
        return $this->consultForGivenCodeTypes($PHPContent, $codeType);
    }

    /**
     * @return CodeType[]
     */
    abstract protected function getRelevantCodeTypes(): array;

    abstract protected function consultForGivenCodeTypes(PHPCode $PHPContent, CodeType $codeType): array;
}