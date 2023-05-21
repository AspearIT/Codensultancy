<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\ASTMapper\ASTMapperInterface;

class ASTMapperFactory
{
    /**
     * @return ASTMapperInterface[]
     */
    public function getASTMappers(): array
    {
        $mapperDir = realpath(__DIR__ . "/ASTMapper");
        $mappers = [];
        foreach (scandir($mapperDir) as $file) {
            if (trim($file, '.') === '') {
                continue;
            }
            $class = __NAMESPACE__ . "\\ASTMapper\\" . preg_replace('/\.php$/', '', $file);
            if ($class === ASTMapperInterface::class) {
                continue;
            }
            $mappers[] = new $class;
        }
        return $mappers;
    }
}