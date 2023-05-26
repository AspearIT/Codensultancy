<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\Array_;
use PhpParser\Node;

class ArrayMapper extends ComplexASTMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            Node\Expr\Array_::class => function (Node\Expr\Array_ $node, ASTNodeParser $parser): Array_ {
                $items = [];
                foreach ($node->items as $item) {
                    $items[] = $parser->mapASTNode($item);
                }
                return new Array_($items);
            },
            Node\Expr\ArrayItem::class => fn (Node\Expr\ArrayItem $node, ASTNodeParser $parser) => $parser->mapASTNode($node->value)->getUnitType(),
        ];
    }
}