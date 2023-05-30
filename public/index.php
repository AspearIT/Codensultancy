<?php

use AspearIT\Codensultancy\Consultant\Supplier\DemoSupplier;
use AspearIT\Codensultancy\ConsultantFactory;

require_once __DIR__ . "/../vendor/autoload.php";

$constultant = ConsultantFactory::create()
    ->getConsultant(new DemoSupplier())
;
$consults = $constultant->consult([file_get_contents(__DIR__ . "/../assets/example.php")]);


dd($consults);