<?php

declare(strict_types=1);

namespace Frostaly\Tests\Template;

use Frostaly\Template\TemplateEngine;
use Frostaly\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class TemplateEngineTest extends TestCase
{
    private TemplateRendererInterface|MockObject $renderer;
    private TemplateEngine $engine;

    protected function setUp(): void
    {
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->engine = new TemplateEngine($this->renderer);
    }

    public function testGetDefaultRenderer(): void
    {
        $this->assertSame($this->renderer, $this->engine->getRenderer());
    }

    public function testGetInvalidRenderer(): void
    {
        $this->expectException(RuntimeException::class);
        $this->engine->getRenderer('¯\_(ツ)_/¯');
    }

    public function testSetGetRenderer(): void
    {
        /** @var TemplateRendererInterface|Stub */
        $renderer = $this->createStub(TemplateRendererInterface::class);
        $this->engine->setRenderer($renderer, 'namespace');
        $this->assertSame($renderer, $this->engine->getRenderer('namespace'));
        $this->assertNotSame($renderer, $this->engine->getRenderer());
    }

    public function testExists(): void
    {
        $this->renderer->method('exists')->willReturnMap([
            ['template.html', true],
            ['¯\_(ツ)_/¯.html', false],
        ]);
        $this->assertTrue($this->engine->exists('template.html'));
        $this->assertFalse($this->engine->exists('¯\_(ツ)_/¯.html'));
    }

    public function testRender(): void
    {
        $this->renderer->method('render')->willReturnCallback(function (string $name, array $params) {
            return sprintf('%s:[%s]', $name, implode(',', $params));
        });
        $this->assertEquals('template.html:[foo,bar]', $this->engine->render('template.html', ['foo', 'bar']));
    }

    public function testExtension(): void
    {
        $engine = new TemplateEngine($this->renderer, 'ext');
        $this->renderer->expects($this->once())->method('exists')->with($this->stringEndsWith('.ext'));
        $this->renderer->expects($this->once())->method('render')->with($this->stringEndsWith('.ext'));
        $engine->exists('template');
        $engine->render('template');
    }

    public function testNamespace(): void
    {
        /** @var TemplateRendererInterface|MockObject */
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects($this->once())->method('exists');
        $renderer->expects($this->once())->method('render');
        $this->engine->setRenderer($renderer, 'namespace');
        $this->engine->exists('namespace::template.html');
        $this->engine->render('namespace::template.html');
    }
}
