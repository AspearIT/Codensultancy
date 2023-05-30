<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class PropertyAccessVariable extends Variable
{
    public function __construct(
        private readonly PHPCode $object,
        private readonly PHPCode $property,
    ) {
        parent::__construct($this->object->getOriginalCode() . "->" . $this->property->getOriginalCode());
    }

    public function getInnerCode(): array
    {
        $innerCode = parent::getInnerCode();
        $innerCode[] = $this->object;
        $innerCode[] = $this->property;
        return $innerCode;
    }
}