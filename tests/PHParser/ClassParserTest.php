<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Class_;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class ClassParserTest extends ParserTestCase
{
    public function testParser_can_parse_empty_class()
    {
        $phpType = $this->parser()->parse('class Foo {}')->getUnitType();
        $this->assertInstanceOf(Class_::class, $phpType);
        $this->assertCount(0, $phpType->getCodeSubUnits());
    }

    public function testParser_can_parse_class_method()
    {
        $phpType = $this->parser()->parse('class Foo {
            public function bar(string $var): string {
                return $var;
            }
        }')->getUnitType();
        $this->assertInstanceOf(Class_::class, $phpType);
        $this->assertCount(1, $phpType->getCodeSubUnits());
    }

    public function testParser_can_parse_php7_properties()
    {
        $phpType = $this->parser()->parse('class Foo {
            private string $bar;
            
            public function __construct(string $bar) {
                $this->bar = $bar;
            }
        }')->getUnitType();
        $this->assertCount(2, $phpType->getCodeSubUnits());
        $this->assertInstanceOf(Variable::class, $phpType->getCodeSubUnits()[0]->getUnitType());
        $this->assertInstanceOf(Method::class, $phpType->getCodeSubUnits()[1]->getUnitType());
    }
}