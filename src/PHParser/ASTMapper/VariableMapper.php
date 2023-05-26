<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use AspearIT\Codensultancy\PHParser\Value\Variable;
use PhpParser\Builder\Property;
use PhpParser\Node;

class VariableMapper extends ComplexASTMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            Node\Expr\Variable::class => fn (Node\Expr\Variable $node) => new Variable($node->name),
            Node\Param::class => fn (Node\Param $node) => new Variable($node->var->name),
            Node\Stmt\Property::class => fn (Node\Stmt\Property $node) => new Variable($node->props[0]->name->name),
        ];
    }
}