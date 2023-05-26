<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Calculation;
use AspearIT\Codensultancy\PHParser\Value\EchoStatement;
use AspearIT\Codensultancy\PHParser\Value\MethodCall;
use AspearIT\Codensultancy\PHParser\Value\Value;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class OneLinerParserTest extends ParserTestCase
{
    public function testParser_can_compile_supported_one_liners()
    {
        $parser = $this->parser();
        foreach ($this->getOneLiners() as $phpCode => $expectations) {
            $parsedCode = $parser->parse($phpCode);
            $this->assertInstanceOf($expectations[0], $parsedCode->getUnitType());
            $this->assertCount(count($expectations[1]), $parsedCode->getUnitType()->getCodeSubUnits());
            foreach ($parsedCode->getUnitType()->getCodeSubUnits() as $subCode) {
                $this->assertInstanceOf(array_shift($expectations[1]), $subCode->getUnitType());
            }
        }
    }

    private function getOneLiners(): array
    {
        return [
            '<?php echo "Hello world";' => [EchoStatement::class, [Value::class]],
            '$foo = 1 + 2;' => [Assign::class, [Calculation::class]],
            '$bar + $i;' => [Calculation::class, [Variable::class, Variable::class]],
            '$this->property = 5;' => [Assign::class, [Value::class]],
            '$property = 5;' => [Assign::class, [Value::class]],
            '$foo / $bar;' => [Calculation::class, [Variable::class, Variable::class]],
            'aRandomMethodCall();' => [MethodCall::class, []],
            'aRandomMethodCall($param, $this->otherMethodCall());' => [MethodCall::class, [Variable::class, MethodCall::class]],
            'true;' => [Value::class, []],
        ];
    }
}