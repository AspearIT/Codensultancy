<?php

namespace AspearIT\Codensultancy;

use Illuminate\Contracts\Container\Container;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\PrettyPrinterAbstract;
use Psr\Container\ContainerInterface;

class App
{
    private static App $app;
    public static function init(): void
    {
        self::$app = new self(\Illuminate\Container\Container::getInstance());
        self::$app->boot();
    }

    public static function container(): Container
    {
        if (self::$app === null) {
            throw new \LogicException("App is not initialized yet");
        }
        return self::$app->container;
    }

    private function __construct(private readonly Container $container) {}

    private function boot()
    {
        $this->container->bind(ContainerInterface::class, fn () => $this->container);
        $this->container->bind(PrettyPrinterAbstract::class, Standard::class);
        $this->container->singleton(Parser::class, fn () => (new ParserFactory())->create(ParserFactory::PREFER_PHP7));
    }
}