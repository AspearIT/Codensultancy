<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\Calculation;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;

class CalculationMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof BinaryOp;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        /* @var $ASTNode BinaryOp */
        return new Calculation(
            $parser->mapASTNode($ASTNode->left),
            $parser->mapASTNode($ASTNode->right),
            $ASTNode->getOperatorSigil(),
        );
    }
}