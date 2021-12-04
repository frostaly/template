<?php

declare(strict_types=1);

namespace Frostaly\Tests\Template\Adapters;

use Frostaly\Template\Adapters\TwigRendererAdapter;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class TwigRendererAdapterTest extends TestCase
{
    private TwigRendererAdapter $renderer;

    protected function setUp(): void
    {
        $storage = vfsStream::setup('templates');
        $storage->addChild(vfsStream::newFile('template')->setContent('foo: {{foo}}'));
        $this->renderer = new TwigRendererAdapter(vfsStream::url('templates'));
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
        $this->expectException(\Twig\Error\LoaderError::class);
        $this->renderer->render('¯\_(ツ)_/¯');
    }
}