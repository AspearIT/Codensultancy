<?php

namespace AspearIT\Codensultancy\PHParser\Value;

interface PHPCodeType
{
    /**
     * @return PHPCode[]
     */
    public function getInnerCode(): array;
}
