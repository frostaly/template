<?php

declare(strict_types=1);

namespace Frostaly\Template;

use Frostaly\Template\Contracts\RendererAdapterInterface;

class TemplateRenderer
{
    public function __construct(
        private RendererAdapterInterface $renderer,
        private string $extension = 'html',
    ) {}

    /**
     * Check whether a template exists.
     */
    public function exists(string $name): bool
    {
        $template = $this->normalizeTemplate($name);
        return $this->renderer->exists($template);
    }

    /**
     * Render a template with the given parameters.
     */
    public function render(string $name, array $params = []): string
    {
        $template = $this->normalizeTemplate($name);
        return $this->renderer->render($template, $params);
    }

    /**
     * Normalize the template's name.
     */
    private function normalizeTemplate(string $name): string
    {
        if (preg_match('#\.[a-z]+$#i', $name)) {
            return $name;
        }
        return sprintf('%s.%s', $name, $this->extension);
    }
}
