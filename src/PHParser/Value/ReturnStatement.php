<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class ReturnStatement implements PHPCodeType
{
    public function __construct(private readonly PHPCode $phpCode) {}

    public function getCodeSubUnits(): array
    {
        return [$this->phpCode];
    }
}