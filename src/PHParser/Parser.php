<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\UnclassifiedUnits;
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
        $parsedContent = $this->parser->parse($phpCode);
        $units = [];
        foreach ($parsedContent as $content) {
            $units[] = $this->mapASTNode($content);
        }
        return match(count($units)) {
            0 => throw new \DomainException("No PHP units found"),
            1 => $units[array_key_first($units)],
            default => new PHPCode(new UnclassifiedUnits($units), $phpCode),
        };
    }

    public function nodeToCode(Node ...$nodes): string
    {
        return $this->prettyPrinter->prettyPrint($nodes);
    }

    public function mapASTNode(Node $content): PHPCode
    {
        foreach ($this->ASTMapperFactory->getASTMappers() as $ASTMapper) {
            if ($ASTMapper->isApplicable($content)) {
                $unitType = $ASTMapper->map($content, $this);
                return new PHPCode($unitType, $this->nodeToCode($content));
            }
        }
        if ($content instanceof Expression) {
            return $this->mapASTNode($content->expr);
        }
        dd("No parser for ", $this->nodeToCode($content), $content);
    }
}