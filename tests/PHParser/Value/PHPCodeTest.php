<?php

namespace PHParser\Value;

use AspearIT\Codensultancy\PHParser\Exception\PHPCodeUnitTypeException;
use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\CodeCollection;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeType;
use AspearIT\Codensultancy\PHParser\Value\Value;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class PHPCodeTest extends ParserTestCase
{
    public function test_shouldBeTypeOf_should_pass_when_right_type_is_given()
    {
        $this->expectNotToPerformAssertions();

        $phpCode = new PHPCode(new Variable('foo'), '$foo');
        $phpCode->shouldBeTypeOf(Variable::class);
    }

    public function test_shouldBeTypeOf_should_throw_exception_when_wrong_type_is_given()
    {
        $phpCode = new PHPCode(new Value('"foo"'), '"foo"');
        $this->expectException(PHPCodeUnitTypeException::class);
        $phpCode->shouldBeTypeOf(Variable::class);
    }

    public function test_getInnerCode_should_only_return_direct_children()
    {
        $phpCode = new PHPCode(
            $this->mockPHPCodeType([
                new PHPCode($this->mockPHPCodeType([]), '$foo'),
                new PHPCode($this->mockPHPCodeType([
                    new PHPCode($this->mockPHPCodeType([]), '$foo2'),
                ]), '$bar'),
            ]),
            '$foo = $bar;',
        );
        $this->assertCount(2, $phpCode->getInnerCode());
        $this->assertEquals('$foo', $phpCode->getInnerCode()[0]->getOriginalCode());
        $this->assertEquals('$bar', $phpCode->getInnerCode()[1]->getOriginalCode());
    }

    public function test_getInnerCodeRecursive_should_return_all_children()
    {
        $phpCode = new PHPCode(
            $this->mockPHPCodeType([
                new PHPCode($this->mockPHPCodeType([]), '$foo'),
                new PHPCode($this->mockPHPCodeType([
                    new PHPCode($this->mockPHPCodeType([]), '$foo2'),
                ]), '$bar'),
            ]),
            '$foo = $bar;',
        );
        $this->assertCount(3, $phpCode->getInnerCodeRecursive());
        $this->assertEquals('$foo', $phpCode->getInnerCodeRecursive()[0]->getOriginalCode());
        $this->assertEquals('$bar', $phpCode->getInnerCodeRecursive()[1]->getOriginalCode());
        $this->assertEquals('$foo2', $phpCode->getInnerCodeRecursive()[2]->getOriginalCode());
    }

    public function test_code_collections_are_ignored_in_recursive_search()
    {
        $phpCode = new PHPCode(new CodeCollection([
            new PHPCode(new Assign(new PHPCode(new Variable('foo'), '$foo'), new PHPCode(new Variable('bar'), '$bar')), '$foo = $bar'),
            new PHPCode(new CodeCollection([]), '$foo2'),
        ]), 'foo');
        $this->assertCount(3, $phpCode->getInnerCodeRecursive());
        $this->assertCount(0, $phpCode->getInnerCodeFromType(CodeCollection::class));
    }

    public function test_getInnerCodeFromType_returns_all_children_from_given_type()
    {
        $phpCode = new PHPCode(new CodeCollection([
            new PHPCode(new Assign(new PHPCode(new Variable('foo'), '$foo'), new PHPCode(new Variable('bar'), '$bar')), '$foo = $bar'),
            new PHPCode(new Variable('foo2'), '$foo2'),
        ]), 'foo');
        $variables = $phpCode->getInnerCodeFromType(Variable::class);
        $this->assertCount(3, $variables);
    }

    private function mockPHPCodeType(array $innerPHPCode)
    {
        return  \Mockery::mock(PHPCodeType::class, [
            'getInnerCode' => $innerPHPCode,
        ]);
    }
}