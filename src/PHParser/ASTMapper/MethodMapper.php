<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\Comments;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\Param;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnit;
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
            $params[] = new PHPCodeUnit(new Param($param->var->name, $param->type->name), $parser->nodeToCode($param));
        }
        $body = [];
        foreach ($ASTNode->stmts as $stmt) {
            $body[] = $parser->mapASTNode($stmt);
        }
        $commentText = "";
        foreach ($ASTNode->getComments() as $comment) {
            $commentText .= $comment->getText();
        }

        $comments = new PHPCodeUnit(new Comments(), $commentText);
        return new Method(
            $ASTNode->name->name,
            $params,
            $ASTNode->returnType->name,
            $comments,
            $body,
        );
    }
}