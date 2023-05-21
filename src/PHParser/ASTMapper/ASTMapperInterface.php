<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnitType;
use PhpParser\Node;

interface ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool;

    public function map(Node $ASTNode, Parser $parser): PHPCodeUnitType;
}