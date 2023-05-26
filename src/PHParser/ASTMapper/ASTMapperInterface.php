<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

interface ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool;

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType;
}