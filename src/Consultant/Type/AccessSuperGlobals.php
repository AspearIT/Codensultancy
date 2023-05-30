<?php

namespace AspearIT\Codensultancy\Consultant\Type;

use AspearIT\Codensultancy\Consultant\Value\Consult;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class AccessSuperGlobals implements ConsultantInterface
{
    public function consult(PHPCode $PHPContent): array
    {
        $globals = $this->getAllPHPSuperGlobalNames();
        $consults = [];
        foreach ($PHPContent->getInnerCodeFromType(Variable::class) as $innerCode) {
            /* @var $variable Variable */
            $variable = $innerCode->getUnitType();
            if (in_array($variable->getName(), $globals, true)) {
                $consults[] = new Consult($innerCode, "You should not access super globals directly. This should be handled by the framework.");
            }
        }
        return $consults;
    }

    /**
     * @return string[]
     */
    private function getAllPHPSuperGlobalNames(): array
    {
        return array_keys($GLOBALS);
    }

    /**
     * @return Variable[]
     */
    private function getAllVariables(PHPCode $code): array
    {
        $result = [];
        foreach ($code->getInnerCodeFromType(Variable::class) as $variable) {
            $result[] = $variable->getUnitType();
        }
        return $result;
    }
}