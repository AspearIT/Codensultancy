<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\ReturnStatement;
use AspearIT\Codensultancy\PHParser\Value\Variable;
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
        $method = $this->assertMethod($phpCodeUnit, 'toString', []);
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
        $method = $this->assertMethod($phpCodeUnit, 'toString', [ReturnStatement::class]);
        $this->assertEquals('string', $method->getReturnType());
    }

    public function testParser_can_compile_input_args()
    {
        $phpCodeUnit = $this->parser()->parse('<?php

function toString($in): string
{   
    $out = $in->doSometing();
    
    return $out;
}
        ');
        $method = $this->assertMethod($phpCodeUnit, 'toString', [
            Variable::class,
            Assign::class,
            ReturnStatement::class,
        ]);
        $this->assertCount(3, $method->getInnerCode());
    }

    private function assertMethod(PHPCode $codeUnit, string $expectedMethodName, array $expectedSubClasses): Method
    {
        $unitType = $codeUnit->getCodeType();
        $this->assertInstanceOf(Method::class, $unitType);
        $this->assertEquals($expectedMethodName, $unitType->getMethodName());
        $this->assertCount(count($expectedSubClasses), $unitType->getInnerCode());
        foreach ($unitType->getInnerCode() as $subCode) {
            $this->assertInstanceOf(array_shift($expectedSubClasses), $subCode->getCodeType());
        }

        return $unitType;
    }
}