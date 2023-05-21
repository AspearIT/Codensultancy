<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnit;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PHPUnit\Framework\TestCase;

class MethodParserTest extends ParserTestCase
{
    public function testParser_can_compile_basic_function()
    {
        $phpCodeUnit = $this->parser()->parse('<?php

function toString()
{

}
        ');
        $method = $this->assertMethod($phpCodeUnit, 'toString', 0);
        $this->assertCount(0, $method->getParams());
        $this->assertNull($method->getReturnType());
    }

    public function testParser_can_compile_function_with_return_type()
    {
        $phpCodeUnit = $this->parser()->parse('<?php

function toString(): string
{
    return "foo";
}
        ');
        $method = $this->assertMethod($phpCodeUnit, 'toString', 1);
        $this->assertCount(0, $method->getParams());
        $this->assertEquals('string', $method->getReturnType());
    }

    private function assertMethod(PHPCodeUnit $codeUnit, string $expectedMethodName, int $expectedBodyCount): Method
    {
        $unitType = $codeUnit->getUnitType();
        $this->assertInstanceOf(Method::class, $unitType);
        $this->assertEquals($expectedMethodName, $unitType->getMethodName());
        $this->assertCount($expectedBodyCount, $unitType->getBody());

        return $unitType;
    }
}