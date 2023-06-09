<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use AspearIT\Codensultancy\PHParser\Value\ThrowStatement;
use PhpParser\Node;

class ThrowMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Stmt\Throw_;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        return new ThrowStatement($parser->mapASTNode($ASTNode->expr));
    }
}