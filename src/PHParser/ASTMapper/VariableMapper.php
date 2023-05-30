<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\ArrayAccessVariable;
use AspearIT\Codensultancy\PHParser\Value\PropertyAccessVariable;
use AspearIT\Codensultancy\PHParser\Value\PropertyVariable;
use AspearIT\Codensultancy\PHParser\Value\Variable;
use PhpParser\Node;

class VariableMapper extends ComplexASTMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            Node\Expr\Variable::class => fn (Node\Expr\Variable $node)
                => new Variable($node->name),
            Node\Param::class => fn (Node\Param $node)
                => new Variable($node->var->name),
            Node\Stmt\Property::class => fn (Node\Stmt\Property $node)
                => new Variable($node->props[0]->name->name),
            Node\Expr\ArrayDimFetch::class => fn (Node\Expr\ArrayDimFetch $node, ASTNodeParser $parser)
                => new ArrayAccessVariable($parser->mapASTNode($node->var), $parser->mapASTNode($node->dim)),
            Node\Expr\PropertyFetch::class => fn (Node\Expr\PropertyFetch $node, ASTNodeParser $parser)
                => new PropertyAccessVariable($parser->mapASTNode($node->var), $parser->mapASTNode($node->name)),
            Node\Identifier::class => fn (Node\Identifier $node)
                => new PropertyVariable($node->name),
        ];
    }
}