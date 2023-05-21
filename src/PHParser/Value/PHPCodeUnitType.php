<?php

namespace AspearIT\Codensultancy\PHParser\Value;

interface PHPCodeUnitType
{
    /**
     * @return PHPCodeUnit[]
     */
    public function getCodeSubUnits(): array;
}
