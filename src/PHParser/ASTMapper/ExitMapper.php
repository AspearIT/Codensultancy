<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\ExitStatement;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

class ExitMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Expr\Exit_;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        $innerExpression = null;
        if ($ASTNode->expr !== null) {
            $innerExpression = $parser->mapASTNode($ASTNode->expr);
        }
        return new ExitStatement($innerExpression);
    }
}