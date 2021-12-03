<?php

declare(strict_types=1);

namespace Frostaly\Tests\Template\Renderers;

use Frostaly\Template\Renderers\PlatesTemplateRenderer;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class PlatesTemplateRendererTest extends TestCase
{
    private PlatesTemplateRenderer $renderer;

    protected function setUp(): void
    {
        $storage = vfsStream::setup('templates');
        $storage->addChild(vfsStream::newFile('template')->setContent('foo: <?=$this->e($foo)?>'));
        $this->renderer = new PlatesTemplateRenderer(vfsStream::url('templates'));
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
        $this->expectException(\LogicException::class);
        $this->renderer->render('¯\_(ツ)_/¯');
    }
}
