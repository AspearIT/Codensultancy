<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Concatenation implements PHPCodeType
{
    public function __construct(
        private readonly array $items,
    ) {}

    public function getInnerCode(): array
    {
        return $this->items;
    }
}