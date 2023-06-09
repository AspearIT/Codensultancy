<?php

namespace AspearIT\Codensultancy\PHParser\Value;

readonly class ThrowStatement implements PHPCodeType
{
    private PHPCode $throwable;

    public function __construct(PHPCode $throwable)
    {
        $this->throwable = $throwable;
    }

    public function getInnerCode(): array
    {
        return [$this->throwable];
    }
}