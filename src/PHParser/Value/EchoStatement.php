<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class EchoStatement implements PHPCodeType
{
    public function __construct(private readonly PHPCode $codeToEcho) {}

    public function getCodeSubUnits(): array
    {
        return [$this->codeToEcho];
    }
}