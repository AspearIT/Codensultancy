<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\Comments;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

class MethodMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Stmt\Function_ || $ASTNode instanceof Node\Stmt\ClassMethod;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        /* @var Node\Stmt\Function_ $ASTNode */
        $params = [];
        foreach ($ASTNode->params as $param) {
            $params[] = $parser->mapASTNode($param);
        }
        $body = [];
        foreach ($ASTNode->stmts as $stmt) {
            $body[] = $parser->mapASTNode($stmt);
        }
        $comments = null;
        if (count($ASTNode->getComments()) > 0) {
            $commentText = "";
            foreach ($ASTNode->getComments() as $comment) {
                $commentText .= $comment->getText();
            }
            $comments = new PHPCode(new Comments(), $commentText, 0, 0);//TODO comments should be handled different
        }

        return new Method(
            $ASTNode->name->name,
            $params,
            $ASTNode->returnType?->name,
            $comments,
            $body,
        );
    }
}