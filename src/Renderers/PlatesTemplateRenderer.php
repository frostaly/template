<?php

declare(strict_types=1);

namespace Frostaly\Template\Renderers;

use Frostaly\Template\TemplateRendererInterface;
use League\Plates\Engine;

class PlatesTemplateRenderer implements TemplateRendererInterface
{
    protected Engine $engine;

    public function __construct(
        protected string $viewPath,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function exists(string $name): bool
    {
        return $this->getEngine()->exists($name);
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $name, array $params = []): string
    {
        return $this->getEngine()->render($name, $params);
    }

    /**
     * Get the Plates template Engine.
     */
    protected function getEngine(): Engine
    {
        return $this->engine ??= $this->createEngine();
    }

    /**
     * Create the Plates template Engine.
     */
    protected function createEngine(): Engine
    {
        $engine = new Engine($this->viewPath);
        return $engine->setFileExtension(null);
    }
}
