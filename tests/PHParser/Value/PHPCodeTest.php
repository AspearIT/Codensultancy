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

        $phpCode = new PHPCode(new Variable('foo'), '$foo', 2, 2);
        $phpCode->shouldBeTypeOf(Variable::class);
    }

    public function test_shouldBeTypeOf_should_throw_exception_when_wrong_type_is_given()
    {
        $phpCode = new PHPCode(new Value('"foo"'), '"foo"', 2, 2);
        $this->expectException(PHPCodeUnitTypeException::class);
        $phpCode->shouldBeTypeOf(Variable::class);
    }

    public function test_getInnerCode_should_only_return_direct_children()
    {
        $phpCode = new PHPCode(
            $this->mockPHPCodeType([
                new PHPCode($this->mockPHPCodeType([]), '$foo', 1, 1),
                new PHPCode($this->mockPHPCodeType([
                    new PHPCode($this->mockPHPCodeType([]), '$foo2', 2, 2),
                ]), '$bar', 2, 2),
            ]),
            '$foo = $bar;',
            1,
            2,
        );
        $this->assertCount(2, $phpCode->getInnerCode());
        $this->assertEquals('$foo', $phpCode->getInnerCode()[0]->getOriginalCode());
        $this->assertEquals('$bar', $phpCode->getInnerCode()[1]->getOriginalCode());
    }

    public function test_getInnerCodeRecursive_should_return_all_children()
    {
        $phpCode = new PHPCode(
            $this->mockPHPCodeType([
                new PHPCode($this->mockPHPCodeType([]), '$foo', 2, 2),
                new PHPCode($this->mockPHPCodeType([
                    new PHPCode($this->mockPHPCodeType([]), '$foo2', 2, 2),
                ]), '$bar', 2, 2),
            ]),
            '$foo = $bar;',
            2,
            2,
        );
        $this->assertCount(3, $phpCode->getInnerCodeRecursive());
        $this->assertEquals('$foo', $phpCode->getInnerCodeRecursive()[0]->getOriginalCode());
        $this->assertEquals('$bar', $phpCode->getInnerCodeRecursive()[1]->getOriginalCode());
        $this->assertEquals('$foo2', $phpCode->getInnerCodeRecursive()[2]->getOriginalCode());
    }

    public function test_code_collections_are_ignored_in_recursive_search()
    {
        $phpCode = new PHPCode(new CodeCollection([
            new PHPCode(new Assign(new PHPCode(new Variable('foo'), '$foo', 2, 2), new PHPCode(new Variable('bar'), '$bar', 2, 2)), '$foo = $bar', 2, 2),
            new PHPCode(new CodeCollection([]), '$foo2', 2, 2),
        ]), 'foo', 2, 2);
        $this->assertCount(3, $phpCode->getInnerCodeRecursive());
    }

    public function test_getCodeFromType_returns_all_children_from_given_type()
    {
        $phpCode = new PHPCode(new CodeCollection([
            new PHPCode(new Assign(new PHPCode(new Variable('foo'), '$foo', 2, 2), new PHPCode(new Variable('bar'), '$bar', 2, 2)), '$foo = $bar', 2, 2),
            new PHPCode(new Variable('foo2'), '$foo2', 2, 2),
        ]), 'foo', 2, 2);
        $variables = $phpCode->getCodeFromType(Variable::class);
        $this->assertCount(3, $variables);
    }

    public function test_getCodeFromType_returns_itself_ïf_self_of_requested_type()
    {
        $phpCode = new PHPCode(new Variable('foo'), '$foo', 2, 2);
        $variables = $phpCode->getCodeFromType(Variable::class);
        $this->assertCount(1, $variables);
    }

    private function mockPHPCodeType(array $innerPHPCode)
    {
        return  \Mockery::mock(PHPCodeType::class, [
            'getInnerCode' => $innerPHPCode,
        ]);
    }
}