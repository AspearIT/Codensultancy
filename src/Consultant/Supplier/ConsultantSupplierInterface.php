<?php

namespace AspearIT\Codensultancy\Consultant\Supplier;

use AspearIT\Codensultancy\Consultant\Type\ConsultantInterface;

interface ConsultantSupplierInterface
{
    /**
     * @return ConsultantInterface[]
     */
    public function getConsultants(): array;
}