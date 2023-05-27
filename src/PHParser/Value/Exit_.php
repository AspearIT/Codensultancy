<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Exit_ implements PHPCodeType
{
    public function __construct(private readonly ?PHPCode $input) {}

    public function getCodeSubUnits(): array
    {
        return array_filter([$this->input]);
    }
}