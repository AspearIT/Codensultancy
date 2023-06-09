<?php

namespace AspearIT\Codensultancy\Consultant;

use AspearIT\Codensultancy\Codensultant;
use AspearIT\Codensultancy\PHParser;
use Illuminate\Contracts\Container\Container;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\PrettyPrinterAbstract;
use Psr\Container\ContainerInterface;

class ConsultantFactory
{
    public static function create(): self
    {
        return new self(\Illuminate\Container\Container::getInstance());
    }

    private function __construct(private readonly Container $container)
    {
        $this->boot();
    }

    private function boot()
    {
        $this->container->bind(ContainerInterface::class, fn () => $this->container);
        $this->container->bind(PrettyPrinterAbstract::class, Standard::class);
        $this->container->singleton(Parser::class, fn () => (new ParserFactory())->create(ParserFactory::PREFER_PHP7));
    }

    public function getConsultant(ConsultantSupplierInterface $consultantSupplier): Codensultant
    {
        return $this->container->make(Codensultant::class, [
            'consultantSupplier' => $consultantSupplier,
        ]);
    }

    public function getParser(): PHParser\Parser
    {
        return $this->container->get(PHParser\Parser::class);
    }
}