<?php

namespace AspearIT\Codensultancy\Demo\Consultant;

use AspearIT\Codensultancy\CodeType\CodeType;
use AspearIT\Codensultancy\Consultant\Type\ConsultantInterface;
use AspearIT\Codensultancy\Consultant\Value\Consult;
use AspearIT\Codensultancy\PHParser\LookUp;
use AspearIT\Codensultancy\PHParser\Value\Concatenation;
use AspearIT\Codensultancy\PHParser\Value\PHPCode;
use AspearIT\Codensultancy\PHParser\Value\Value;
use AspearIT\Codensultancy\PHParser\Value\Variable;

class NoVariablesInSQL implements ConsultantInterface
{
    public function consult(PHPCode $PHPContent, CodeType $codeType): array
    {
        $concatenations = $PHPContent->getCodeFromType(Concatenation::class);
        $consults = [];
        foreach ($concatenations as $concatenation) {
            if (!$this->isProbablySQL($concatenation)) {
                continue;
            }
            $innerVariables = $concatenation->getCodeFromType(Variable::class);
            foreach ($innerVariables as $variable) {
                $consults[] = new Consult($concatenation, "You should not use variables in SQL ({$variable->getCodeType()->getName()}). This can lead to SQL injection vulnerabilities.");
            }
        }
        return $consults;
    }

    private function isProbablySQL(PHPCode $concatenation): bool
    {
        foreach ($concatenation->getInnerCode() as $innerCode) {
            $codeType = $innerCode->getCodeType();
            if ($codeType instanceof Value && $this->stringIsProbablyPartOfSQL($codeType->getValue())) {
                return true;
            }
        }
        return false;
    }

    private function stringIsProbablyPartOfSQL(string $string): bool
    {
        $pattern = "/(SELECT|INSERT|UPDATE|DELETE|CREATE|ALTER|DROP|TRUNCATE|FROM|INTO|VALUES|SET|WHERE|AND|OR|LIMIT|ORDER BY|GROUP BY|HAVING|JOIN|INNER JOIN|LEFT JOIN|RIGHT JOIN|OUTER JOIN|UNION|UNION ALL|LIKE|AS|ON|\*|\(|\)|\b[A-Z][A-Z_]+\b)/i";
        return (bool) preg_match($pattern, $string);
    }
}