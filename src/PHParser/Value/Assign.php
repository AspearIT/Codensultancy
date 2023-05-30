<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Assign implements PHPCodeType
{
    public function __construct(
        private readonly PHPCode $variable,
        private readonly PHPCode $assignedExpression,
    ) {
        $this->variable->shouldBeTypeOf(Variable::class);
    }

    public function getInnerCode(): array
    {
        return [
            $this->variable,
            $this->assignedExpression,
        ];
    }
}