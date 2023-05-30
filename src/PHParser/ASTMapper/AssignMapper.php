<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

class AssignMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Expr\Assign;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        return new Assign(
            $parser->mapASTNode($ASTNode->var),
            $parser->mapASTNode($ASTNode->expr),
        );
    }
}