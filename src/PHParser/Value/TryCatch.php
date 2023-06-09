<?php

namespace AspearIT\Codensultancy\PHParser\Value;

readonly class TryCatch implements PHPCodeType
{
    /**
     * @param PHPCode $codeToTry
     * @param PHPCode[] $catches
     */
    public function __construct(
        private PHPCode $codeToTry,
        private array $catches,
    ) {
        foreach ($this->catches as $catch) {
            $catch->shouldBeTypeOf(CatchStatement::class);
        }
    }

    public function getInnerCode(): array
    {
        return array_merge([$this->codeToTry], $this->catches);
    }
}