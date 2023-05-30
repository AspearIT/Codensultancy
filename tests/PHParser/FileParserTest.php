<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\CodeCollection;
use AspearIT\Codensultancy\PHParser\Value\Import;
use AspearIT\Codensultancy\PHParser\Value\MethodCall;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class FileParserTest extends ParserTestCase
{
    public function testParse_will_ignore_namespace_and_can_handle_imports()
    {
        $phpCode = $this->parser()->parse('<?php
 namespace Foo\Bar;

 use Bar\Foo;

 $foo = bar();
        ');

        $this->assertPHPCodeStructure($phpCode, CodeCollection::class, [
            Import::class,
            Assign::class,
            Variable::class,
            MethodCall::class
        ]);
    }

    public function testParse_can_handle_multiple_imports()
    {
        $phpCode = $this->parser()->parse('<?php
 namespace Foo\Bar;

 use Bar\Foo;
 use Foo\Bar;
 use Foo\Bar2;

 $foo = bar();
        ');
        $this->assertPHPCodeStructure($phpCode, CodeCollection::class, [
            Import::class,
            Import::class,
            Import::class,
            Assign::class,
            Variable::class,
            MethodCall::class
        ]);
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
        $this->assertPHPCodeStructure($phpCode, CodeCollection::class, [
            Import::class,
            Import::class,
            Assign::class,
            Variable::class,
            MethodCall::class
        ]);
    }
}