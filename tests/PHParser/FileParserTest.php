<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\CodeCollection;

class FileParserTest extends ParserTestCase
{
    public function testParse_will_ignore_namespace_and_can_handle_imports()
    {
        $phpCode = $this->parser()->parse('<?php
 namespace Foo\Bar;

 use Bar\Foo;

 $foo = bar();
        ')->getUnitType();
        $this->assertInstanceOf(CodeCollection::class, $phpCode);
        $this->assertCount(2, $phpCode->getCodeSubUnits());
    }

    public function testParse_can_handle_multiple_imports()
    {
        $phpCode = $this->parser()->parse('<?php
 namespace Foo\Bar;

 use Bar\Foo;
 use Foo\Bar;
 use Foo\Bar2;

 $foo = bar();
        ')->getUnitType();
        $this->assertInstanceOf(CodeCollection::class, $phpCode);
        $this->assertCount(4, $phpCode->getCodeSubUnits());
    }

    public function testParse_can_handle_nested_multiple_imports()
    {
        $phpCode = $this->parser()->parse('<?php
 namespace Foo\Bar;
 
 use Bar\{
    Foo,
    Foo2,
 };
 
 $foo = bar();
        ');
        $this->assertInstanceOf(CodeCollection::class, $phpCode->getUnitType());
        $this->assertCount(4, $phpCode->getSubCodeUnitsRecursive());
    }
}