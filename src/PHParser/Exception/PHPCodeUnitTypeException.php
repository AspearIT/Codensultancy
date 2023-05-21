<?php

namespace AspearIT\Codensultancy\PHParser\Exception;

use AspearIT\Codensultancy\PHParser\Value\Param;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnitType;

class PHPCodeUnitTypeException extends \Exception
{
    public static function forWrongUnitTypeGiven(string $expectedClassName, PHPCodeUnitType $givenType): self
    {
        return new self(sprintf(
            "Unit type of params should be an instance of %s, %s given",
            $expectedClassName,
            get_class($givenType),
        ));
    }
}