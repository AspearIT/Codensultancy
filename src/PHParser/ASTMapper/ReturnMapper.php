<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use AspearIT\Codensultancy\PHParser\Value\ReturnStatement;
use PhpParser\Node;

class ReturnMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Stmt\Return_;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        return new ReturnStatement($parser->mapASTNode($ASTNode->expr));
    }
}