<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\ArrayAccessVariable;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Calculation;
use AspearIT\Codensultancy\PHParser\Value\Concatenation;
use AspearIT\Codensultancy\PHParser\Value\EchoStatement;
use AspearIT\Codensultancy\PHParser\Value\MethodCall;
use AspearIT\Codensultancy\PHParser\Value\PropertyAccessVariable;
use AspearIT\Codensultancy\PHParser\Value\PropertyVariable;
use AspearIT\Codensultancy\PHParser\Value\Value;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class OneLinerParserTest extends ParserTestCase
{
    public function testParser_can_compile_supported_one_liners()
    {
        $parser = $this->parser();
        foreach ($this->getOneLiners() as $phpCode => $expectations) {
            $parsedCode = $parser->parse($phpCode);
            $this->assertInstanceOf($expectations[0], $parsedCode->getCodeType(), $phpCode);
            $this->assertCount(count($expectations[1]), $parsedCode->getCodeType()->getInnerCode(), $phpCode);
            foreach ($parsedCode->getCodeType()->getInnerCode() as $subCode) {
                $this->assertInstanceOf(array_shift($expectations[1]), $subCode->getCodeType(), $phpCode);
            }
        }
    }

    private function getOneLiners(): array
    {
        return [
            '<?php echo "Hello world";' => [EchoStatement::class, [Value::class]],
            '$foo = 1 + 2;' => [Assign::class, [Variable::class, Calculation::class]],
            '$bar + $i;' => [Calculation::class, [Variable::class, Variable::class]],
            '$this->property = 5;' => [Assign::class, [Variable::class, Value::class]],
            '$property = 5;' => [Assign::class, [Variable::class, Value::class]],
            '$foo / $bar;' => [Calculation::class, [Variable::class, Variable::class]],
            'aRandomMethodCall();' => [MethodCall::class, []],
            'aRandomMethodCall($param, $this->otherMethodCall());' => [MethodCall::class, [Variable::class, MethodCall::class]],
            'true;' => [Value::class, []],
            '$cart = $array["cart_id"];' => [Assign::class, [Variable::class, Variable::class]],
            '$cart["cart_id"] = $variable;' => [Assign::class, [ArrayAccessVariable::class, Variable::class]],
            '$array["cart_id"][0];' => [ArrayAccessVariable::class, [ArrayAccessVariable::class, Value::class]],
            '$object->subObject->property;' => [PropertyAccessVariable::class, [PropertyAccessVariable::class, PropertyVariable::class]],
            '"SELECT * FROM table WHERE prop = $var1";' => [Concatenation::class, [Value::class, Variable::class]],
            '"SELECT * FROM table WHERE prop = $var1 AND method = " . method();' => [Concatenation::class, [Concatenation::class, MethodCall::class]],
        ];
    }
}