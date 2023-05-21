<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class UnclassifiedUnits implements PHPCodeUnitType
{
    /**
     * @param PHPCodeUnitType[] $codeParts
     */
    public function __construct(
        private readonly array $codeParts,
    ) {}

    public function getCodeSubUnits(string $originalCode): array
    {
        return $this->codeParts;
    }
}