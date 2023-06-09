<?php

namespace AspearIT\Codensultancy\Demo\Consultant;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\Consultant\Type\NotForAllTypesOfCode;
use AspearIT\Codensultancy\Consultant\Value\Consult;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class AccessSuperGlobals extends NotForAllTypesOfCode
{
    protected function getExcludedCodeTypes(): array
    {
        return [
            CodeType::FRAMEWORK,
        ];
    }

    protected function consultForOtherCodeTypes(PHPCode $PHPContent, CodeType $codeType): array
    {
        $globals = $this->getAllPHPSuperGlobalNames();
        $consults = [];
        foreach ($PHPContent->getCodeFromType(Variable::class) as $innerCode) {
            /* @var $variable Variable */
            $variable = $innerCode->getCodeType();
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
}