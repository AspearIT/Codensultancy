<?php

namespace AspearIT\Codensultancy\Consultant\Type;

use AspearIT\Codensultancy\Consultant\Value\Consult;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\PHPContent;

interface ConsultantInterface
{
    /**
     * @return Consult[]
     */
    public function consult(PHPCode $PHPContent): array;
}