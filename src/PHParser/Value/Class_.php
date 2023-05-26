<?php

namespace AspearIT\Codensultancy\PHParser\Value;

class Class_ implements PHPCodeType
{
    /**
     * @param PHPCode[] $methods
     */
    public function __construct(
        private readonly array $properties,
        private readonly array $methods,
    ) {
        foreach ($this->properties as $property) {
            $property->shouldBeTypeOf(Variable::class);
        }
        foreach ($this->methods as $method) {
            $method->shouldBeTypeOf(Method::class);
        }
    }

    public function getCodeSubUnits(): array
    {
        $subUnits = [];
        $subUnits = array_merge($subUnits, $this->properties);
        $subUnits = array_merge($subUnits, $this->methods);

        return $subUnits;
    }
}