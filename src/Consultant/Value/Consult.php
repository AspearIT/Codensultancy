<?php

namespace AspearIT\Codensultancy\Consultant\Value;

use AspearIT\Codensultancy\PHParser\Value\PHPCode;

class Consult
{
    public function __construct(
        private readonly PHPCode $phpCode,
        private readonly string $description,
    ) {}

    public function getPhpCode(): PHPCode
    {
        return $this->phpCode;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}