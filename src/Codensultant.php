<?php

namespace AspearIT\Codensultancy;

use AspearIT\Codensultancy\Consultant\Supplier\ConsultantSupplierInterface;
use AspearIT\Codensultancy\Consultant\Value\Consult;
use AspearIT\Codensultancy\Input\InputInterface;
use AspearIT\Codensultancy\Output\OutputInterface;
use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\PHPContent;

class Codensultant
{
    public function __construct(
        private readonly Parser $parser,
        private readonly ConsultantSupplierInterface $consultantSupplier,
    ) {}

    /**
     * @param string[] $php
     * @return Consult[]
     */
    public function consult(array $php): array
    {
        $result = [];
        foreach ($php as $phpCode) {
            $phpUnit = $this->parser->parse($phpCode);

            foreach ($this->consultantSupplier->getConsultants() as $consultant) {
                $consults = $consultant->consult($phpUnit);
                $result = array_merge($result, $consults);
            }
        }
        return $result;
    }
}