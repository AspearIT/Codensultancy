<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class CodeCollection implements PHPCodeType
{
    /**
     * @param PHPCode[] $codeParts
     */
    public function __construct(
        private readonly array $codeParts,
    ) {}

    public function getInnerCode(): array
    {
        return $this->codeParts;
    }
}