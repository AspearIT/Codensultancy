<?php

namespace AspearIT\Codensultancy\Demo;

use AspearIT\Codensultancy\Consultant\ConsultantSupplierInterface;
use AspearIT\Codensultancy\Demo\Consultant\AccessSuperGlobals;

class DemoSupplier implements ConsultantSupplierInterface
{
    public function getConsultants(): array
    {
        return [
            new AccessSuperGlobals(),
        ];
    }
}