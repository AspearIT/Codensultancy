<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnitType;
use AspearIT\Codensultancy\PHParser\Value\SimpleUnitPHP;
use PhpParser\Node;

class SimpleExpression implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Expr\BinaryOp\Plus;
    }

    public function map(Node $ASTNode, Parser $parser): PHPCodeUnitType
    {
        return new SimpleUnitPHP();
    }
}