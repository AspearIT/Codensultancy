<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\CatchStatement;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;

class TryCatchMapper extends NodeGroupMapper
{
    protected function getSupportedNodes(): array
    {
        return [
            TryCatch::class => fn (TryCatch $node, ASTNodeParser $parser) => $this->parseTryCatch($node, $parser),
            Catch_::class => fn (Catch_ $node, ASTNodeParser $parser) => $this->parseCatch($node, $parser),
        ];
    }

    private function parseTryCatch(TryCatch $node, ASTNodeParser $parser): \AspearIT\Codensultancy\PHParser\Value\TryCatch
    {
        $body = $parser->mapASTNodes($node->stmts);
        $catches = [];
        foreach ($node->catches as $catch) {
            $catches[] = $parser->mapASTNode($catch);
        }
        return new \AspearIT\Codensultancy\PHParser\Value\TryCatch($body, $catches);
    }

    private function parseCatch(Catch_ $node, ASTNodeParser $parser): CatchStatement
    {
        $throwables = [];
        foreach ($node->types as $type) {
            $throwables[] = implode('\\', $type->parts);
        }
        $body = $parser->mapASTNodes($node->stmts);
        return new CatchStatement($throwables, $body);
    }
}