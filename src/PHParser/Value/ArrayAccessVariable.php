<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class ArrayAccessVariable extends Variable
{
    /**
     * @param PHPCode[] $keysUsedForAccess
     */
    public function __construct(
        private readonly PHPCode $array,
        private readonly PHPCode $key,
    ) {
        parent::__construct(trim($this->array->getOriginalCode(), '$') . "[{$this->key->getOriginalCode()}]");
    }

    public function getInnerCode(): array
    {
        $innerCode = parent::getInnerCode();
        $innerCode[] = $this->array;
        $innerCode[] = $this->key;

        return $innerCode;
    }
}