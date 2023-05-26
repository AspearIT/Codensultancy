<?php

namespace AspearIT\Codensultancy\PHParser\Value;

use AspearIT\Codensultancy\PHParser\Exception\PHPCodeUnitTypeException;

class Method implements PHPCodeType
{
    /**
     * @param PHPCode[] $params
     * @param PHPCode[] $body
     */
    public function __construct(
        private readonly string   $methodName,
        private readonly array    $params,
        private readonly ?string  $returnType,
        private readonly ?PHPCode $comments,
        private readonly array    $body,
    ) {
        foreach ($this->params as $param) {
            $param->shouldBeTypeOf(Variable::class);
        }
        if ($this->comments !== null) {
            $this->comments->shouldBeTypeOf(Comments::class);
        }
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return PHPCode[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function getReturnType(): ?string
    {
        return $this->returnType;
    }

    public function getComments(): ?PHPCode
    {
        return $this->comments;
    }

    /**
     * @return PHPCode[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    public function getCodeSubUnits(): array
    {
        return array_filter(array_merge([$this->comments], $this->params, $this->body));
    }
}