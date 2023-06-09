<?php

namespace Demo\Consultant;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\Consultant\ConsultantTestCase;
use AspearIT\Codensultancy\Demo\Consultant\AccessSuperGlobals;
use AspearIT\Codensultancy\Demo\Consultant\NoVariablesInSQL;

class NoVariablesInSQLTest extends ConsultantTestCase
{
    public function test_consult_should_warn_when_variables_are_used_in_sql()
    {
        $parsedCode = $this->parser()->parse('$sql = "UPDATE table SET column = $value WHERE 1=1";');
        $consultant = new NoVariablesInSQL();
        $consults = $consultant->consult($parsedCode, CodeType::UNDEFINED);
        $this->assertCount(1, $consults);
    }

    public function test_consult_should_have_no_consults_when_sql_is_ok()
    {
        $parsedCode = $this->parser()->parse('$sql = "UPDATE table SET column = :value WHERE 1=1";');
        $consultant = new NoVariablesInSQL();
        $consults = $consultant->consult($parsedCode, CodeType::UNDEFINED);
        $this->assertCount(0, $consults);
    }
}