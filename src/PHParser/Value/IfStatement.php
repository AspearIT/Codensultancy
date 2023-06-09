<?php
declare(strict_types=1);

namespace AspearIT\Codensultancy\PHParser\Value;

readonly class IfStatement implements PHPCodeType
{
    /**
     * @param PHPCode $checks
     * @param PHPCode $codeIfTrue
     * @param PHPCode[] $elseIfStatements
     * @param PHPCode|null $elseStatement
     */
    public function __construct(
        private PHPCode $checks,
        private PHPCode $codeIfTrue,
        private array $elseIfStatements,
        private ?PHPCode $elseStatement,
    ) {
        foreach ($this->elseIfStatements as $elseIfStatement) {
            $elseIfStatement->shouldBeTypeOf(self::class);
            $elseIfStatement->getCodeType()->shouldBeAnElseIfStatement();
        }
    }

    public function getChecks(): PHPCode
    {
        return $this->checks;
    }

    public function getCodeIfTrue(): PHPCode
    {
        return $this->codeIfTrue;
    }

    /**
     * @return PHPCode[]
     */
    public function getElseIfStatements(): array
    {
        return $this->elseIfStatements;
    }

    public function getElseStatement(): ?PHPCode
    {
        return $this->elseStatement;
    }

    public function getInnerCode(): array
    {
        return array_merge(
            [
                $this->checks,
                $this->codeIfTrue,
            ],
            $this->elseIfStatements,
            array_filter([
                $this->elseStatement,
            ])
        );
    }

    private function shouldBeAnElseIfStatement(): void
    {
        if ($this->elseStatement !== null) {
            throw new \LogicException("Else if statements can't have an else statement");
        }
        if (count($this->elseIfStatements) > 0) {
            throw new \LogicException("Else if statements can't have other else if statements");
        }
    }
}