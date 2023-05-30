<?php

namespace AspearIT\Codensultancy\Consultant;

use AspearIT\Codensultancy\PHParser\ParserTestCase;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;

class ConsultantTestCase extends ParserTestCase
{
    protected function getPHPCode(string $code): PHPCode
    {
        return $this->parser()->parse($code);
    }
}