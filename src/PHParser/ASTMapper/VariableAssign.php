<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnitType;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

class VariableAssign implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Expression && $ASTNode->expr instanceof Assign && $ASTNode->expr->var instanceof Variable;
    }

    public function map(Node $ASTNode, Parser $parser): PHPCodeUnitType
    {
        return new \AspearIT\Codensultancy\PHParser\Value\Assign(
            $ASTNode->expr->var->name,
            $parser->mapASTNode($ASTNode->expr->expr),
        );
    }
}