<?php

declare(strict_types=1);

namespace Frostaly\Template\Adapters;

use Frostaly\Template\Contracts\RendererAdapterInterface;
use Twig\Environment as Engine;
use Twig\Loader;

class TwigRendererAdapter implements RendererAdapterInterface
{
    protected Engine $engine;

    public function __construct(
        protected string $viewPath,
        protected ?string $cachePath = null,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function exists(string $name): bool
    {
        return $this->getEngine()->getLoader()->exists($name);
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $name, array $params = []): string
    {
        return $this->getEngine()->render($name, $params);
    }

    /**
     * Get the Twig template Engine.
     */
    protected function getEngine(): Engine
    {
        return $this->engine ??= $this->createEngine();
    }

    /**
     * Get the Twig template Engine.
     */
    protected function createEngine(): Engine
    {
        return new Engine(
            new Loader\FilesystemLoader($this->viewPath),
            ["cache" => $this->cachePath ?? false],
        );
    }
}
