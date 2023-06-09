<?php

namespace AspearIT\Codensultancy\PHParser\ASTMapper;

use AspearIT\Codensultancy\PHParser\ASTNodeParser;
use AspearIT\Codensultancy\PHParser\Value\CodeCollection;
use AspearIT\Codensultancy\PHParser\Value\Import;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use PhpParser\Node;
use PhpParser\PrettyPrinterAbstract;

class FileMapper extends NodeGroupMapper
{
    public function __construct(private readonly PrettyPrinterAbstract $prettyPrinter) {}

    protected function getSupportedNodes(): array
    {
        return [
            Node\Stmt\Namespace_::class => fn (Node\Stmt\Namespace_ $node, ASTNodeParser $parser) => $parser->mapASTNodes($node->stmts)->getCodeType(),
            Node\Stmt\UseUse::class => fn () => throw new \LogicException(sprintf(
                "%s nodes should be handled by the %s mapping",
                Node\Stmt\UseUse::class,
                Node\Stmt\GroupUse::class,
            )),
            Node\Stmt\Use_::class => fn (Node\Stmt\Use_ $node) => new Import($node->uses[0]->name->parts),
            Node\Stmt\GroupUse::class => function (Node\Stmt\GroupUse $node, ASTNodeParser $nodeParser) {
                $result = [];
                $baseParts = $node->prefix->parts;
                foreach ($node->uses as $useNode) {
                    $currentUseParts = array_merge($baseParts, $useNode->name->parts);
                    $result[] = new PHPCode(new Import($currentUseParts), $this->prettyPrinter->prettyPrint([$node]), $useNode->getStartLine(), $useNode->getEndLine());
                }
                return new CodeCollection($result);
            },
        ];
    }
}