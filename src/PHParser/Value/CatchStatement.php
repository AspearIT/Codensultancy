<?php

namespace AspearIT\Codensultancy\PHParser\Value;

readonly class CatchStatement implements PHPCodeType
{
    /**
     * @param string[] $exceptionClassNames
     */
    public function __construct(
        private array $exceptionClassNames,
        private ?PHPCode $catchBody,
    ) {}

    /**
     * @return string[]
     */
    public function getExceptionClassNames(): array
    {
        return $this->exceptionClassNames;
    }

    public function getInnerCode(): array
    {
        return array_filter([
            $this->catchBody,
        ]);
    }
}