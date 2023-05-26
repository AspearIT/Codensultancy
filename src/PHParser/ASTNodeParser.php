<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use PhpParser\Node;

interface ASTNodeParser
{
    public function mapASTNode(Node $content): PHPCode;

}