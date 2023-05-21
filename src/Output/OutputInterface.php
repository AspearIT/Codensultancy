<?php

namespace AspearIT\Codensultancy\Output;

use AspearIT\Codensultancy\Consultant\Value\Consult;

interface OutputInterface
{
    public function outputConsult(Consult $consult);
}