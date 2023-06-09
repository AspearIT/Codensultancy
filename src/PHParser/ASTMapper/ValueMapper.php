<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\Value\Value;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;

class ValueMapper extends NodeGroupMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            LNumber::class => fn (LNumber $ASTNode) => new Value((string) $ASTNode->value),
            String_::class => fn (String_ $ASTNode) => new Value($ASTNode->value),
            ConstFetch::class => fn (ConstFetch $ASTNode) => new Value($ASTNode->name->parts[0]),
        ];
    }
}