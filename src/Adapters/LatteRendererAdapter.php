<?php

declare(strict_types=1);

namespace Frostaly\Template\Adapters;

use Frostaly\Template\Contracts\RendererAdapterInterface;
use Latte\Engine;
use Latte\Loaders\FileLoader;

class LatteRendererAdapter implements RendererAdapterInterface
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
        return file_exists($this->viewPath . '/' . $name);
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $name, array $params = []): string
    {
        return $this->getEngine()->renderToString($name, $params);
    }

    /**
     * Get the Latte template Engine.
     */
    protected function getEngine(): Engine
    {
        return $this->engine ??= $this->createEngine();
    }

    /**
     * Create the Latte template Engine.
     */
    protected function createEngine(): Engine
    {
        $engine = new Engine();
        $engine->setLoader(new FileLoader($this->viewPath));
        return $engine->setTempDirectory($this->cachePath);
    }
}
