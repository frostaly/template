<?php

declare(strict_types=1);

namespace Frostaly\Template\Renderers;

use Frostaly\Template\TemplateRendererInterface;
use Twig\Environment;
use Twig\Loader;

class TwigTemplateRenderer implements TemplateRendererInterface
{
    protected Environment $environment;

    public function __construct(
        protected string $viewPath,
        protected ?string $cachePath = null,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function exists(string $name): bool
    {
        return $this->getEnvironment()->getLoader()->exists($name);
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $name, array $params = []): string
    {
        return $this->getEnvironment()->render($name, $params);
    }

    /**
     * Get the Twig template Environment.
     */
    protected function getEnvironment(): Environment
    {
        return $this->environment ??= new Environment(
            new Loader\FilesystemLoader($this->viewPath),
            ["cache" => $this->cachePath ?? false],
        );
    }
}
