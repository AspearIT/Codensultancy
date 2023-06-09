<?php

namespace AspearIT\Codensultancy\CodeType;

use AspearIT\Codensultancy\PHParser\Value\PHPCode;

interface CodeTypeDetectorInterface
{
    /**
     * Probably it's auto detectable??
     *
     * @return CodeType
     */
    public function detectCodeType(PHPCode $code): CodeType;
}