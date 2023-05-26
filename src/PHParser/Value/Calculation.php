<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Calculation implements PHPCodeType
{
    public function __construct(
        private readonly PHPCode $first,
        private readonly PHPCode $second,
        private readonly string  $operator,
    ) {}

    public function getCodeSubUnits(): array
    {
        return [
            $this->first,
            $this->second,
        ];
    }
}