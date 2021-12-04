<?php

declare(strict_types=1);

namespace Frostaly\Tests\Template;

use Frostaly\Template\TemplateEngine;
use Frostaly\Template\TemplateRenderer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class TemplateEngineTest extends TestCase
{
    private TemplateRenderer|MockObject $renderer;
    private TemplateEngine $engine;

    protected function setUp(): void
    {
        $this->renderer = $this->createMock(TemplateRenderer::class);
        $this->engine = new TemplateEngine($this->renderer);
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

    public function testSetGetRenderer(): void
    {
        /** @var TemplateRenderer|Stub */
        $renderer = $this->createStub(TemplateRenderer::class);
        $this->engine->setRenderer($renderer, 'namespace');
        $this->assertSame($renderer, $this->engine->getRenderer('namespace'));
        $this->assertSame($this->renderer, $this->engine->getRenderer());
        $this->assertNotSame($renderer, $this->engine->getRenderer());
    }

    public function testGetInvalidRenderer(): void
    {
        $this->expectException(RuntimeException::class);
        $this->engine->getRenderer('¯\_(ツ)_/¯');
    }

    public function testNamespace(): void
    {
        /** @var TemplateRenderer|MockObject */
        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())->method('exists');
        $renderer->expects($this->once())->method('render');
        $this->engine->setRenderer($renderer, 'namespace');
        $this->engine->exists('namespace::template.html');
        $this->engine->render('namespace::template.html');
    }
}
