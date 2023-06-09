<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\ClassStatement;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class ClassParserTest extends ParserTestCase
{
    public function testParser_can_parse_empty_class()
    {
        $phpType = $this->parser()->parse('class Foo {}')->getCodeType();
        $this->assertInstanceOf(ClassStatement::class, $phpType);
        $this->assertCount(0, $phpType->getInnerCode());
    }

    public function testParser_can_parse_class_method()
    {
        $phpType = $this->parser()->parse('class Foo {
            public function bar(string $var): string {
                return $var;
            }
        }')->getCodeType();
        $this->assertInstanceOf(ClassStatement::class, $phpType);
        $this->assertCount(1, $phpType->getInnerCode());
    }

    public function testParser_can_parse_php7_properties()
    {
        $phpType = $this->parser()->parse('class Foo {
            private string $bar;
            
            public function __construct(string $bar) {
                $this->bar = $bar;
            }
        }')->getCodeType();
        $this->assertCount(2, $phpType->getInnerCode());
        $this->assertInstanceOf(Variable::class, $phpType->getInnerCode()[0]->getCodeType());
        $this->assertInstanceOf(Method::class, $phpType->getInnerCode()[1]->getCodeType());
    }
}