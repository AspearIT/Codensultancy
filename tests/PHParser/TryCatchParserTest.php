<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Assign;
use AspearIT\Codensultancy\PHParser\Value\CatchStatement;
use AspearIT\Codensultancy\PHParser\Value\MethodCall;
use AspearIT\Codensultancy\PHParser\Value\ReturnStatement;
use AspearIT\Codensultancy\PHParser\Value\TryCatch;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class TryCatchParserTest extends ParserTestCase
{
    public function testParserCanParseSimpleTryCatch()
    {
        $code = $this->parser()->parse('try {
            $var = method();
        } catch (Exception $exception) {
            return $invalidResponse;
        }');

        $this->assertPHPCodeStructure($code, TryCatch::class, [
            Assign::class,
            Variable::class,
            MethodCall::class,
            CatchStatement::class,
            ReturnStatement::class,
            Variable::class,
        ]);
    }
}