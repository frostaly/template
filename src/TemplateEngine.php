<?php

declare(strict_types=1);

namespace Frostaly\Template;

class TemplateEngine
{
    /**
     * The namespace used by default.
     */
    public const DEFAULT_NAMESPACE = '__MAIN_NAMESPACE__';

    private array $renderers = [];
    private string $extension;

    /**
     * Create the Engine that renders templates.
     */
    public function __construct(TemplateRendererInterface $renderer, string $extension = 'html')
    {
        $this->renderers[self::DEFAULT_NAMESPACE] = $renderer;
        $this->extension = $extension;
    }

    /**
     * Check whether a template exists.
     *
     * This method supports the "namespace::template" naming convention
     * and allows omitting the default filename extension.
     */
    public function exists(string $name): bool
    {
        [$namespace, $template] = $this->normalizeTemplate($name);
        return $this->getRenderer($namespace)->exists($template);
    }

    /**
     * Render a template with the given parameters.
     *
     * This method supports the "namespace::template" naming convention
     * and allows omitting the default filename extension.
     */
    public function render(string $name, array $params = []): string
    {
        [$namespace, $template] = $this->normalizeTemplate($name);
        return $this->getRenderer($namespace)->render($template, $params);
    }

    /**
     * Get the renderer used by the given namespace.
     */
    public function getRenderer(string $namespace = self::DEFAULT_NAMESPACE): TemplateRendererInterface
    {
        if (!isset($this->renderers[$namespace])) {
            throw new \RuntimeException("Namespace \"$namespace\" does not exist");
        }
        return $this->renderers[$namespace];
    }

    /**
     * Set the renderer used by the given namespace.
     */
    public function setRenderer(TemplateRendererInterface $renderer, string $namespace = self::DEFAULT_NAMESPACE): self
    {
        $this->renderers[$namespace] = $renderer;
        return $this;
    }

    /**
     * Normalize the template's name.
     */
    private function normalizeTemplate(string $name): array
    {
        $template = explode('::', $name, 2);
        $template[1] ?? array_unshift($template, self::DEFAULT_NAMESPACE);
        if (!preg_match('#\.[a-z]+$#i', $template[1])) {
            $template[1] = sprintf('%s.%s', $template[1], $this->extension);
        }
        return $template;
    }
}
