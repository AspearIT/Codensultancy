<?php

namespace AspearIT\Codensultancy\Consultant\Type;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\Consultant\Value\Consult;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;

interface ConsultantInterface
{
    /**
     * @return Consult[]
     */
    public function consult(PHPCode $PHPContent, CodeType $codeType): array;
}