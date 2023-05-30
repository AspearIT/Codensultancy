<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class MethodCall implements PHPCodeType
{
    /**
     * @param PHPCode[] $input
     */
    public function __construct(
        private readonly string $methodName,
        private readonly array $input,
    ) {}

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return PHPCode[]
     */
    public function getInput(): array
    {
        return $this->input;
    }

    public function getInnerCode(): array
    {
        return $this->input;
    }
}