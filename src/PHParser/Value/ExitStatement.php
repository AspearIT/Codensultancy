<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class ExitStatement implements PHPCodeType
{
    public function __construct(private readonly ?PHPCode $input) {}

    public function getInnerCode(): array
    {
        return array_filter([$this->input]);
    }
}