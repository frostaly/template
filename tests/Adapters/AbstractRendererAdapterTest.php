<?php

declare(strict_types=1);

namespace Frostaly\Template\Tests\Adapters;

use Frostaly\Template\Contracts\RendererAdapterInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractRendererAdapterTest extends TestCase
{
    protected RendererAdapterInterface $renderer;

    public function testExists(): void
    {
        $this->assertTrue($this->renderer->exists('template'));
        $this->assertFalse($this->renderer->exists('¯\_(ツ)_/¯'));
    }

    public function testRenderValidTemplate(): void
    {
        $this->assertEquals('foo: bar', $this->renderer->render('template', ['foo' => 'bar']));
    }

    public function testRenderInvalidTemplate(): void
    {
        $this->expectException(\Throwable::class);
        $this->renderer->render('¯\_(ツ)_/¯');
    }
}
