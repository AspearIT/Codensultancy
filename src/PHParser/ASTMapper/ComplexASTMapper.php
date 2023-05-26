<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

abstract class ComplexASTMapper implements ASTMapperInterface
{
    final public function isApplicable(Node $ASTNode): bool
    {
        $callback = $this->getSupportedNodes();
        return isset($callback[get_class($ASTNode)]);
    }

    final public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        $callback = $this->getSupportedNodes();
        return call_user_func_array($callback[get_class($ASTNode)], [$ASTNode, $parser]);
    }

    abstract protected function getSupportedNodes(): array;
}