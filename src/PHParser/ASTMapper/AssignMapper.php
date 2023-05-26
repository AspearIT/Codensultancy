<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use PhpParser\Node;

class AssignMapper implements ASTMapperInterface
{
    public function isApplicable(Node $ASTNode): bool
    {
        return $ASTNode instanceof Node\Expr\Assign;
    }

    public function map(Node $ASTNode, ASTNodeParser $parser): PHPCodeType
    {
        if ($ASTNode->var instanceof Node\Expr\Variable) {
            $name = $ASTNode->var->name;
        } elseif ($ASTNode->var instanceof Node\Expr\PropertyFetch) {
            $name = $ASTNode->var->var->name . "->" . $ASTNode->var->name->name;
        } else {
            throw new \Exception(get_class($ASTNode) . " not supported yet");
        }
        return new Assign($name, $parser->mapASTNode($ASTNode->expr));
    }
}