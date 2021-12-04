<?php

declare(strict_types=1);

namespace Frostaly\Template\Contracts;

interface RendererAdapterInterface
{
    /**
     * Check whether a template exists.
     */
    public function exists(string $name): bool;

    /**
     * Render a template with the given parameters.
     */
    public function render(string $name, array $params = []): string;
}
