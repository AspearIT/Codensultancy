<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\Calculation;
use AspearIT\Codensultancy\PHParser\Value\CodeCollection;
use AspearIT\Codensultancy\PHParser\Value\IfStatement;
use AspearIT\Codensultancy\PHParser\Value\Method;
use AspearIT\Codensultancy\PHParser\Value\MethodCall;
use AspearIT\Codensultancy\PHParser\Value\ReturnStatement;
use AspearIT\Codensultancy\PHParser\Value\Value;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class IfStatementTest extends ParserTestCase
{
    public function testParserCanHandleSimpleIfStatements()
    {
        $code = $this->parser()->parse('if ($boolean) {
            $this->call();
        }');
        $this->assertPHPCodeStructure($code, IfStatement::class, [Variable::class, MethodCall::class]);
    }

    public function testParserCanHandleElseStatementStatements()
    {
        $code = $this->parser()->parse('if ($boolean) {
            $this->call();
        } else {
            $this->callSomethingElse();
        }');
        $this->assertPHPCodeStructure($code, IfStatement::class, [Variable::class, MethodCall::class, MethodCall::class]);
        /* @var $ifStatement IfStatement */
        $ifStatement = $code->getCodeType();
        $this->assertInstanceOf(MethodCall::class, $ifStatement->getElseStatement()->getCodeType());
    }

    public function testParserCanHandleMultipleConditions()
    {
        $code = $this->parser()->parse('if ($boolean && (methodCall() || otherMethodCall())) {
            $this->call();
        }');
        $this->assertPHPCodeStructure($code, IfStatement::class, [
            Calculation::class, //full condition
            Variable::class,
            Calculation::class, // Inner condition
            MethodCall::class,
            MethodCall::class,
            MethodCall::class, // The body
        ]);
    }

    public function testParserCanHandleElseIfStatements()
    {
        $code = $this->parser()->parse('if ($boolean) {
            $this->call();
        } elseif ($otherBoolean) {
            $this->call2();
        } elseif ($againAnotherBoolean) {
            return $foo;
        }');
        $this->assertPHPCodeStructure($code, IfStatement::class, [
            Variable::class,
            MethodCall::class,
            IfStatement::class,
            Variable::class,
            MethodCall::class,
            IfStatement::class,
            Variable::class,
            ReturnStatement::class,
            Variable::class,
        ]);
    }

    public function testParserCanHandleComplexIfStatements()
    {
        $code = $this->parser()->parse('if ($this->booleanCheck() && $someOtherValue) {
            $this->call();
            $var = 2;
        } elseif($trueOrFalse) {
            $var = 3;
        } else {
            $var = 4;
            return $foo;
        }');
        $this->assertPHPCodeStructure($code, IfStatement::class, [
            //If condition
            Calculation::class,
            MethodCall::class,
            Variable::class,

            //If body
            MethodCall::class,
            Assign::class,
            Variable::class,
            Value::class,

            //ElseIf structure
            IfStatement::class,
            Variable::class,
            Assign::class,
            Variable::class,
            Value::class,

            //Else structure
            Assign::class,
            Variable::class,
            Value::class,
            ReturnStatement::class,
            Variable::class,
        ]);
    }
}