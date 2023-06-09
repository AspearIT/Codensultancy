<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\PHParser\Exception\ASTNodeIgnoredException;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\CodeCollection;
use PhpParser\Node;
use PhpParser\Node\Stmt\Expression;
use PhpParser\PrettyPrinterAbstract;

class Parser implements ASTNodeParser
{
    public function __construct(
        private readonly \PhpParser\Parser $parser,
        private readonly PrettyPrinterAbstract $prettyPrinter,
        private readonly ASTMapperFactory $ASTMapperFactory,
    ) {}

    /**
     * @param string $content
     * @return PHPCode
     */
    public function parse(string $phpCode): PHPCode
    {
        if (strpos(trim($phpCode), '<?php') !== 0) {
            $phpCode = '<?php ' . $phpCode;
        }
        return $this->mapASTNodes($this->parser->parse($phpCode));
    }

    public function nodeToCode(Node ...$nodes): string
    {
        $string = '';
        $batch = [];
        foreach ($nodes as $node) {
            if (!$node instanceof Node\Scalar\EncapsedStringPart) {
                $batch[] = $node;
                continue;
            }
            if (count($batch) > 0) {
                $string .= $this->prettyPrinter->prettyPrint($batch);
                $batch = [];
            }
            $string .= $node->value;
        }
        if (count($batch) > 0) {
            $string .= $this->prettyPrinter->prettyPrint($batch);
        }
        return $string;
    }

    /**
     * @param Node[] $contents
     */
    public function mapASTNodes(array $contents): PHPCode
    {
        $units = [];
        foreach ($contents as $content) {
            $units[] = $this->mapASTNode($content);
        }
        return match(count($units)) {
            0 => throw new \DomainException("No PHP units found"),
            1 => $units[array_key_first($units)],
            default => new PHPCode(new CodeCollection($units), $this->nodeToCode(...$contents), $this->getStartLineFromNodes($contents), $this->getEndLineFromNodes($contents)),
        };
    }

    public function mapASTNode(Node $content): PHPCode
    {
        foreach ($this->ASTMapperFactory->getASTMappers() as $ASTMapper) {
            if ($ASTMapper->isApplicable($content)) {
                $unitType = $ASTMapper->map($content, $this);
                return new PHPCode($unitType, $this->nodeToCode($content), $content->getStartLine(), $content->getEndLine());
            }
        }
        if ($content instanceof Expression) {
            return $this->mapASTNode($content->expr);
        }
        dd("No parser for ", $this->nodeToCode($content), $content);
    }

    /**
     * @param Node[] $nodes
     */
    private function getStartLineFromNodes(array $nodes): int
    {
        if (count($nodes) === 0) {
            throw new \LogicException("At least one node expected");
        }
        $start = null;
        foreach ($nodes as $node) {
            if ($start === null || $start > $node->getStartLine()) {
                $start = $node->getStartLine();
            }
        }
        return $start;
    }

    /**
     * @param Node[] $nodes
     */
    private function getEndLineFromNodes(array $nodes): int
    {
        if (count($nodes) === 0) {
            throw new \LogicException("At least one node expected");
        }
        $end = null;
        foreach ($nodes as $node) {
            if ($end === null || $end < $node->getEndLine()) {
                $end = $node->getEndLine();
            }
        }
        return $end;
    }
}