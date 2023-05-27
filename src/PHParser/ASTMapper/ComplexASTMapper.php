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
        $type = call_user_func_array($callback[get_class($ASTNode)], [$ASTNode, $parser]);
        if (!$type instanceof PHPCodeType) {
            throw new \LogicException(get_class($this) . " has a wrong mapper for node " . get_class($ASTNode));
        }
        return $type;
    }

    abstract protected function getSupportedNodes(): array;
}