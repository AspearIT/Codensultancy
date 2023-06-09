<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\Calculation;
use AspearIT\Codensultancy\PHParser\Value\Concatenation;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use AspearIT\Codensultancy\PHParser\Value\Value;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;

class ConcatenatedValueMapper extends ComplexASTMapper
{
    public function mapConcatenatedPart(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        $items = [];
        foreach ($ASTNode->parts as $part) {
            $items[] = $parser->mapASTNode($part);
        }
        return new Concatenation($items);
    }

    protected function getSupportedNodes(): array
    {
        return [
            Node\Scalar\Encapsed::class => fn (Node\Scalar\Encapsed $ASTNode, ASTNodeParser $parser)
                => $this->mapConcatenatedPart($ASTNode, $parser),
            Node\Scalar\EncapsedStringPart::class => fn (Node\Scalar\EncapsedStringPart $ASTNode, ASTNodeParser $parser)
                => new Value($ASTNode->value),
            Node\Expr\BinaryOp\Concat::class => fn (Node\Expr\BinaryOp\Concat $ASTNode, ASTNodeParser $parser)
                => new Concatenation([$parser->mapASTNode($ASTNode->left), $parser->mapASTNode($ASTNode->right)]),
            BinaryOp::class => fn (BinaryOp $node, ASTNodeParser $parser)
                => new Calculation(
                    $parser->mapASTNode($node->left),
                    $parser->mapASTNode($node->right),
                    $node->getOperatorSigil(),
                ),
        ];
    }
}