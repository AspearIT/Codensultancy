<?php

namespace PHParser;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\Assign;

class OneLinerParserTest extends ParserTestCase
{
    public function testParser_can_compile_basic_assign()
    {
        $phpCodeUnit = $this->parser()->parse('<?php

$foo = 1 + 2;
        ');
        $unitType = $phpCodeUnit->getUnitType();
        $this->assertInstanceOf(Assign::class, $unitType);
        $this->assertEquals('foo', $unitType->getVariableName());
        $this->assertCount(1, $unitType->getCodeSubUnits());
        $this->assertEquals('1 + 2', $unitType->getCodeSubUnits()[0]->getOriginalCode());
    }
}