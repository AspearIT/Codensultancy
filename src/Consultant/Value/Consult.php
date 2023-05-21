<?php

namespace AspearIT\Codensultancy\Consultant\Value;

class Consult
{
    public function __construct(
        private readonly int $line,
        private readonly string $phpLine,
        private readonly string $description,
    ) {}

    public function getLine(): int
    {
        return $this->line;
    }

    public function getPhpLine(): string
    {
        return $this->phpLine;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}