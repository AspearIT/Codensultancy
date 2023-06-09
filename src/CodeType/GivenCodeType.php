<?php

namespace AspearIT\Codensultancy\CodeType;

use AspearIT\Codensultancy\PHParser\Value\PHPCode;

class GivenCodeType implements CodeTypeDetectorInterface
{
    public function __construct(
        private readonly CodeType $codeType,
    ) {}

    public function detectCodeType(PHPCode $code): CodeType
    {
        return $this->codeType;
    }
}