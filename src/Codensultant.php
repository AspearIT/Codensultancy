<?php

namespace AspearIT\Codensultancy;

use AspearIT\Codensultancy\CodeType\CodeTypeDetectorInterface;
use AspearIT\Codensultancy\Consultant\ConsultantSupplierInterface;
use AspearIT\Codensultancy\Consultant\Value\Consult;
use AspearIT\Codensultancy\PHParser\Parser;

class Codensultant
{
    public function __construct(
        private readonly Parser $parser,
        private readonly CodeTypeDetectorInterface $codeTypeDetector,
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
            $parsedPHPCode = $this->parser->parse($phpCode);
            $codeType = $this->codeTypeDetector->detectCodeType($parsedPHPCode);

            foreach ($this->consultantSupplier->getConsultants() as $consultant) {
                $consults = $consultant->consult($parsedPHPCode, $codeType);
                $result = array_merge($result, $consults);
            }
        }
        return $result;
    }
}