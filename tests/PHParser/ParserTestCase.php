<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\ConsultantFactory;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PHPUnit\Framework\AssertionFailedError;

class ParserTestCase extends MockeryTestCase
{
    protected function parser(): Parser
    {
        return ConsultantFactory::create()->getParser();
    }

    protected function assertPHPCodeStructure(PHPCode $PHPCode, string $expectedType, array $expectedInnerCodeTypeClassNames): void
    {
        $this->assertInstanceOf($expectedType, $PHPCode->getUnitType());
        foreach ($PHPCode->getInnerCodeRecursive() as $innerCode) {
            $expectedClassName = array_shift($expectedInnerCodeTypeClassNames);
            if ($expectedClassName === null) {
                throw new AssertionFailedError("PHPCode {$PHPCode->getOriginalCode()}  contains unexpected type " . get_class($innerCode->getUnitType()));
            }
            $this->assertInstanceOf($expectedClassName, $innerCode->getUnitType(), $PHPCode->getOriginalCode());
        }
        if (count($expectedInnerCodeTypeClassNames) > 0) {
            throw new AssertionFailedError("PHPCode {$PHPCode->getOriginalCode()} should contain " . implode(', ', $expectedInnerCodeTypeClassNames));
        }
    }
}