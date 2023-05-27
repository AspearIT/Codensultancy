<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\App;
use PHPUnit\Framework\TestCase;

class ParserTestCase extends TestCase
{
    protected function parser(): Parser
    {
        return App::container()->get(Parser::class);
    }
}