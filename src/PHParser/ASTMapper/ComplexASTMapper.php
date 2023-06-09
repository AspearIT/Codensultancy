<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

abstract class ComplexASTMapper implements ASTMapperInterface
{
    final public function isApplicable(Node $ASTNode): bool
    {
        return $this->getProcessorForNode($ASTNode) !== null;
    }

    final public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        $processor = $this->getProcessorForNode($ASTNode) ?? throw new \LogicException("No support for node " . get_class($ASTNode));
        $type = call_user_func_array($processor, [$ASTNode, $parser]);
        if (!$type instanceof PHPCodeType) {
            throw new \LogicException(get_class($this) . " has a wrong mapper for node " . get_class($ASTNode));
        }
        return $type;
    }

    private function getProcessorForNode(Node $ASTNode): ?callable
    {
        $callbacks = $this->getSupportedNodes();
        foreach ($callbacks as $className => $processor) {
            if ($ASTNode instanceof $className) {
                return $processor;
            }
        }
        return null;
    }

    abstract protected function getSupportedNodes(): array;
}