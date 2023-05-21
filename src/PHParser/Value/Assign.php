<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Assign implements PHPCodeUnitType
{
    public function __construct(
        private readonly string $variableName,
        private readonly PHPCodeUnit $assignedExpression,
    ) {}

    public function getCodeSubUnits(): array
    {
        return [
            $this->assignedExpression,
        ];
    }

    public function getVariableName(): string
    {
        return $this->variableName;
    }
}