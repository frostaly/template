<?php

declare(strict_types=1);

namespace Frostaly\Template\Tests;

use Frostaly\Template\Contracts\RendererAdapterInterface;
use Frostaly\Template\TemplateRenderer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TemplateRendererTest extends TestCase
{
    private RendererAdapterInterface|MockObject $renderer;

    protected function setUp(): void
    {
        $this->renderer = $this->createMock(RendererAdapterInterface::class);
    }

    public function testWithExtension(): void
    {
        $renderer = new TemplateRenderer($this->renderer);
        $this->renderer->expects($this->once())->method('exists')->with($this->stringEndsWith('.ext'));
        $this->renderer->expects($this->once())->method('render')->with($this->stringEndsWith('.ext'));
        $renderer->exists('template.ext');
        $renderer->render('template.ext');
    }

    public function testWithoutExtension(): void
    {
        $renderer = new TemplateRenderer($this->renderer, 'ext');
        $this->renderer->expects($this->once())->method('exists')->with($this->stringEndsWith('.ext'));
        $this->renderer->expects($this->once())->method('render')->with($this->stringEndsWith('.ext'));
        $renderer->exists('template');
        $renderer->render('template');
    }
}
