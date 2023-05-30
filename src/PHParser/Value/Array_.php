<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Array_ implements PHPCodeType
{
    /**
     * @param PHPCode[] $items
     */
    public function __construct(private readonly array $items) {}

    public function isAssociative(): bool
    {
        return range(0, count($this->items) - 1) === array_keys($this->items);
    }

    public function getKeys(): array
    {
        return array_keys($this->items);
    }

    public function getInnerCode(): array
    {
        return $this->items;
    }
}