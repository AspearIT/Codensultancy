<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\MethodCall;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use PhpParser\Node;

class MethodCallMapper extends ComplexASTMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            Node\Expr\FuncCall::class => fn (Node\Expr\FuncCall $node, ASTNodeParser $parser) => new MethodCall($node->name->parts[0], $this->getArguments($parser, $node->args)),
            Node\Expr\MethodCall::class => fn (Node\Expr\MethodCall $node, ASTNodeParser $parser) => new MethodCall($node->var->name . "->" . $node->name->name, $this->getArguments($parser, $node->args)),
        ];
    }

    /**
     * @param array $args
     * @return PHPCode[]
     */
    private function getArguments(ASTNodeParser $parser, array $inputArgs): array
    {
        $args = [];
        foreach ($inputArgs as $arg) {
            $args[] = $parser->mapASTNode($arg->value);
        }
        return $args;
    }
}