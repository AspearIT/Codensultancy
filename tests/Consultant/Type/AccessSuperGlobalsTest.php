<?php

namespace Consultant\Type;

use AspearIT\Codensultancy\Consultant\ConsultantTestCase;
use AspearIT\Codensultancy\Consultant\Type\AccessSuperGlobals;

class AccessSuperGlobalsTest extends ConsultantTestCase
{
    public function test_consult_should_warn_when_super_globals_are_accessed_directly()
    {
        $consultant = new AccessSuperGlobals();
        $consults = $consultant->consult($this->getPHPCode('$_POST["foo"] = "bar";'));
        $this->assertCount(1, $consults);
    }
}