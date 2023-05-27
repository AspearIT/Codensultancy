<?php

namespace AspearIT\Codensultancy\PHParser;

use AspearIT\Codensultancy\PHParser\ASTMapper\ASTMapperInterface;
use AspearIT\Codensultancy\PHParser\ASTMapper\ComplexASTMapper;
use Psr\Container\ContainerInterface;

class ASTMapperFactory
{
    public function __construct(private readonly ContainerInterface $container) {}

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
            $class = $this->getClassNameFromFile($file);
            if ($class === ASTMapperInterface::class || $class === ComplexASTMapper::class) {
                continue;
            }
            $mappers[] = $this->container->get($class);
        }
        return $mappers;
    }

    private function getClassNameFromFile(string $fileName): string
    {
        return __NAMESPACE__ . "\\ASTMapper\\" . preg_replace('/\.php$/', '', $fileName);
    }
}