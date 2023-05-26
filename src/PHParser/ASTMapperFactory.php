<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\ASTMapper\ASTMapperInterface;
use AspearIT\Codensultancy\PHParser\ASTMapper\ComplexASTMapper;

class ASTMapperFactory
{
    /**
     * @return ASTMapperInterface[]
     */
    public function getASTMappers(): array
    {
        $mapperDir = realpath(__DIR__ . "/ASTMapper");
        $mappers = [];
        //TODO find a better way. This one is easy but dirty
        foreach (scandir($mapperDir) as $file) {
            if (trim($file, '.') === '') {
                continue;
            }
            $class = __NAMESPACE__ . "\\ASTMapper\\" . preg_replace('/\.php$/', '', $file);
            if ($class === ASTMapperInterface::class || $class === ComplexASTMapper::class) {
                continue;
            }
            $mappers[] = new $class;
        }
        return $mappers;
    }
}