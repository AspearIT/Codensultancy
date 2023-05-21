<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Method;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PHPUnit\Framework\TestCase;

class ParserTestCase extends TestCase
{
    protected function parser(): Parser
    {
        return new Parser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new Standard(),
            new ASTMapperFactory(),
        );
    }
}