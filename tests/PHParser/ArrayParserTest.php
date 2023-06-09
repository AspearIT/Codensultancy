<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Array_;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Calculation;
use AspearIT\Codensultancy\PHParser\Value\EchoStatement;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\MethodCall;
use AspearIT\Codensultancy\PHParser\Value\Value;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class ArrayParserTest extends ParserTestCase
{
    public function testParser_can_compile_empty_array()
    {
        $code = $this->parser()->parse('[];')->getCodeType();
        $this->assertInstanceOf(Array_::class, $code);
        $this->assertCount(0, $code->getInnerCode());

        $code = $this->parser()->parse('array();')->getCodeType();
        $this->assertInstanceOf(Array_::class, $code);
        $this->assertCount(0, $code->getInnerCode());
    }

    public function testParser_can_compile_non_associative_array()
    {
        $code = $this->parser()->parse('["foo", "bar"];')->getCodeType();
        $this->assertInstanceOf(Array_::class, $code);
        $this->assertCount(2, $code->getInnerCode());
    }

    public function testParser_can_compile_associative_array()
    {
        $code = $this->parser()->parse('["foo" => "bar"];')->getCodeType();
        $this->assertInstanceOf(Array_::class, $code);
        $this->assertCount(1, $code->getInnerCode());
    }
}