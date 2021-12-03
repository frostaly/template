<?php

declare(strict_types=1);

namespace Frostaly\Tests\Template\Renderers;

use Frostaly\Template\Renderers\LatteTemplateRenderer;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class LatteTemplateRendererTest extends TestCase
{
    private LatteTemplateRenderer $renderer;

    protected function setUp(): void
    {
        $storage = vfsStream::setup('templates');
        $storage->addChild(vfsStream::newFile('template')->setContent('foo: {$foo}'));
        $this->renderer = new LatteTemplateRenderer(vfsStream::url('templates'));
    }

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
        $this->expectException(\Latte\RuntimeException::class);
        $this->renderer->render('¯\_(ツ)_/¯');
    }
}
