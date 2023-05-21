<?php

namespace AspearIT\Codensultancy;

use AspearIT\Codensultancy\Consultant\Supplier\ConsultantSupplierInterface;
use AspearIT\Codensultancy\Input\InputInterface;
use AspearIT\Codensultancy\Output\OutputInterface;
use AspearIT\Codensultancy\PHParser\Parser;
use AspearIT\Codensultancy\PHParser\Value\PHPCodeUnit;
use AspearIT\Codensultancy\PHParser\Value\PHPContent;

class Codensultant
{
    public function __construct(
        private readonly InputInterface $input,
        private readonly Parser $parser,
        private readonly ConsultantSupplierInterface $consultantSupplier,
        private readonly OutputInterface $output,
    ) {}

    public function consult(): void
    {
        $phpUnit = $this->parser->parse($this->input->getPHPAsString());

        foreach ($this->consultantSupplier->getConsultants() as $consultant) {
            $consults = $consultant->consult($phpUnit);
            foreach ($consults as $consult) {
                $this->output->outputConsult($consult);
            }
        }
    }
}