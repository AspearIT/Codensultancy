<?php

namespace AspearIT\Codensultancy\Consultant;

use AspearIT\Codensultancy\Consultant\Type\ConsultantInterface;

interface ConsultantSupplierInterface
{
    /**
     * @return ConsultantInterface[]
     */
    public function getConsultants(): array;
}