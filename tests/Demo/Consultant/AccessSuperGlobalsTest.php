<?php

namespace Demo\Consultant;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\Consultant\ConsultantTestCase;
use AspearIT\Codensultancy\Demo\Consultant\AccessSuperGlobals;

class AccessSuperGlobalsTest extends ConsultantTestCase
{
    public function test_consult_should_warn_when_super_globals_are_accessed_directly()
    {
        $consultant = new AccessSuperGlobals();
        $consults = $consultant->consult($this->getPHPCode('$_POST["foo"] = "bar";'), CodeType::BUSINESS_LOGIC);
        $this->assertCount(1, $consults);
    }

    public function test_consult_should_allow_direct_access_in_framework_logic()
    {
        $consultant = new AccessSuperGlobals();
        $consults = $consultant->consult($this->getPHPCode('$_POST["foo"] = "bar";'), CodeType::FRAMEWORK);
        $this->assertCount(0, $consults);
    }
}