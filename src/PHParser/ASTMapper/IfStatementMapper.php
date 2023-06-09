<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\IfStatement;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\If_;

class IfStatementMapper extends ComplexASTMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            If_::class => fn (If_ $node, ASTNodeParser $parser) => $this->parseIfStatement($node, $parser),
            ElseIf_::class => fn(ElseIf_ $node, ASTNodeParser $parser) => $this->parseElseIfStatement($node, $parser),
        ];
    }

    private function parseIfStatement(If_ $node, ASTNodeParser $parser): IfStatement
    {
        $elseCode = null;
        if ($node->else) {
            $elseCode = $parser->mapASTNodes($node->else->stmts);
        }
        $elseIfs = [];
        foreach ($node->elseifs as $elseif) {
            $elseIfs[] = $parser->mapASTNode($elseif);
        }
        return new IfStatement(
            $parser->mapASTNode($node->cond),
            $parser->mapASTNodes($node->stmts),
            $elseIfs,
            $elseCode,
        );
    }

    private function parseElseIfStatement(ElseIf_ $node, ASTNodeParser $parser): IfStatement
    {
        return new IfStatement(
            $parser->mapASTNode($node->cond),
            $parser->mapASTNodes($node->stmts),
            [],
            null,
        );
    }
}