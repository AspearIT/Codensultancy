<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Exception\UnsupportedNodeException;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\Variable;
use PhpParser\Node\Stmt\Class_;

class ClassMapper extends ComplexASTMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            Class_::class => fn (Class_ $node, ASTNodeParser $parser) => $this->parseClass($node, $parser),
        ];
    }

    private function parseClass(Class_ $node, ASTNodeParser $parser): \AspearIT\Codensultancy\PHParser\Value\Class_
    {
        $methods = [];
        $properties = [];
        foreach ($node->stmts as $stmt) {
            $code = $parser->mapASTNode($stmt);
            if ($code->getUnitType() instanceof Variable) {
                $properties[] = $code;
            } elseif ($code->getUnitType() instanceof Method) {
                $methods[] = $code;
            } else {
                throw UnsupportedNodeException::forNode($stmt);
            }
        }
        return new \AspearIT\Codensultancy\PHParser\Value\Class_($properties, $methods);
    }
}