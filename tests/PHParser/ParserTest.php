<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Method;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParser_can_compile_basic_assign()
    {
        $phpCodeUnit = $this->parser()->parse('<?php

$foo = 1 + 2;
        ');
        $unitType = $phpCodeUnit->getUnitType();
        $this->assertInstanceOf(Assign::class, $unitType);
        $this->assertEquals('foo', $unitType->getVariableName());
        $this->assertCount(1, $unitType->getCodeSubUnits());
        $this->assertEquals('1 + 2', $unitType->getCodeSubUnits()[0]->getOriginalCode());
    }

    public function testParser_can_compile_function()
    {
        $phpCodeUnit = $this->parser()->parse('<?php

function toString(int $a): string
{
    $b = (string) $a;
    return $b;
}
        ');
        $unitType = $phpCodeUnit->getUnitType();
        $this->assertInstanceOf(Method::class, $unitType);
        $this->assertEquals('toString', $unitType->getMethodName());
        $this->assertCount(2, $unitType->getBody());
        $this->assertCount(1, $unitType->getParams());
        $this->assertEquals('string', $unitType->getReturnType());
    }

    private function parser(): Parser
    {
        return new Parser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new Standard(),
            new ASTMapperFactory(),
        );
    }
}