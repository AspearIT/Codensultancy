<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\Param;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnitType;
use PhpParser\Node;

class MethodMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Stmt\Function_;
    }

    public function map(Node $ASTNode, Parser $parser): PHPCodeUnitType
    {
        /* @var Node\Stmt\Function_ $ASTNode */
        $params = [];
        foreach ($ASTNode->params as $param) {
            $params[] = new Param($param->var->name, $param->type->name);
        }
        dd($ASTNode->returnType);
        dd($ASTNode->stmts);
        return new Method(
            $ASTNode->name->name,
            $params,
        );
    }
}