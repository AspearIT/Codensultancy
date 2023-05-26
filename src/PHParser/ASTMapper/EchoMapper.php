<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\EchoStatement;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

class EchoMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Stmt\Echo_;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        return new EchoStatement($parser->mapASTNode($ASTNode->exprs[0]));
    }
}