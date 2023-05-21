<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Param implements PHPCodeUnitType
{
    public function __construct(
        private string $name,
        private ?string $type,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getCodeSubUnits(): array
    {
        return [];
    }
}