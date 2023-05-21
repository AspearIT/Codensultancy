<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnit;
use AspearIT\Codensultancy\PHParser\Value\SimpleUnitPHP;
use AspearIT\Codensultancy\PHParser\Value\UnclassifiedUnits;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use PhpParser\PrettyPrinterAbstract;

class Parser
{
    public function __construct(
        private readonly \PhpParser\Parser $parser,
        private readonly PrettyPrinterAbstract $prettyPrinter,
        private readonly ASTMapperFactory $ASTMapperFactory,
    ) {}

    /**
     * @param string $content
     * @return PHPCodeUnit
     */
    public function parse(string $phpCode): PHPCodeUnit
    {
        $parsedContent = $this->parser->parse($phpCode);
        $units = [];
        foreach ($parsedContent as $content) {
            $units[] = $this->mapASTNode($content);
        }
        return match(count($units)) {
            0 => throw new \DomainException("No PHP units found"),
            1 => $units[array_key_first($units)],
            default => new PHPCodeUnit(new UnclassifiedUnits($units), $phpCode),
        };
    }

    public function nodeToCode(Node $node): string
    {
        return $this->prettyPrinter->prettyPrint([$node]);
    }

    public function mapASTNode(Node $content): PHPCodeUnit
    {
        foreach ($this->ASTMapperFactory->getASTMappers() as $ASTMapper) {
            if ($ASTMapper->isApplicable($content)) {
                $unitType = $ASTMapper->map($content, $this);
                return new PHPCodeUnit($unitType, $this->nodeToCode($content));
            }
        }
        dd(get_class($content));
    }
}