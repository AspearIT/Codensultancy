<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Exception\UnsupportedNodeException;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\ObjectCreation;
use AspearIT\Codensultancy\PHParser\Value\Variable;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\Class_;

class ClassMapper extends NodeGroupMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            Class_::class => fn (Class_ $node, ASTNodeParser $parser) => $this->parseClass($node, $parser),
            New_::class => fn (New_ $node, ASTNodeParser $parser) => $this->parseObject($node, $parser),
        ];
    }

    private function parseClass(Class_ $node, ASTNodeParser $parser): \AspearIT\Codensultancy\PHParser\Value\ClassStatement
    {
        $methods = [];
        $properties = [];
        foreach ($node->stmts as $stmt) {
            $code = $parser->mapASTNode($stmt);
            if ($code->getCodeType() instanceof Variable) {
                $properties[] = $code;
            } elseif ($code->getCodeType() instanceof Method) {
                $methods[] = $code;
            } else {
                throw UnsupportedNodeException::forNode($stmt);
            }
        }
        return new \AspearIT\Codensultancy\PHParser\Value\ClassStatement($properties, $methods);
    }

    private function parseObject(New_ $node, ASTNodeParser $parser): ObjectCreation
    {
        $args = [];
        foreach ($node->args as $arg) {
            $args[] = $parser->mapASTNode($arg->value);
        }
        return new ObjectCreation(implode('\\', $node->class->parts), $args);
    }
}