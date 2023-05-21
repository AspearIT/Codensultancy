<?php

namespace AspearIT\Codensultancy\PHParser\Value;

use AspearIT\Codensultancy\PHParser\Exception\PHPCodeUnitTypeException;

class Method implements PHPCodeUnitType
{
    /**
     * @param PHPCodeUnit[] $params
     * @param PHPCodeUnit[] $body
     */
    public function __construct(
        private readonly string $methodName,
        private readonly array $params,
        private readonly ?string $returnType,
        private readonly PHPCodeUnit $comments,
        private readonly array $body,
    ) {
        foreach ($this->params as $param) {
            if (!$param->getUnitType() instanceof Param) {
                throw PHPCodeUnitTypeException::forWrongUnitTypeGiven(Param::class, $param->getUnitType());
            }
        }
        if (!$this->comments->getUnitType() instanceof Comments) {
            throw PHPCodeUnitTypeException::forWrongUnitTypeGiven(Comments::class,$this->comments->getUnitType());
        }
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return PHPCodeUnit[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function getReturnType(): ?string
    {
        return $this->returnType;
    }

    public function getComments(): PHPCodeUnit
    {
        return $this->comments;
    }

    /**
     * @return PHPCodeUnit[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    public function getCodeSubUnits(): array
    {
        return array_merge([$this->comments], $this->params, $this->body);
    }
}