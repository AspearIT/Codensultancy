<?php

namespace AspearIT\Codensultancy\Consultant\Supplier;

use AspearIT\Codensultancy\Consultant\Type\AccessSuperGlobals;

class DemoSupplier implements ConsultantSupplierInterface
{
    public function getConsultants(): array
    {
        return [
            new AccessSuperGlobals(),
        ];
    }
}