<?php

declare(strict_types=1);

namespace Frostaly\Template\Tests\Adapters;

use Frostaly\Template\Adapters\TwigRendererAdapter;
use org\bovigo\vfs\vfsStream;

class TwigRendererAdapterTest extends AbstractRendererTest
{
    protected function setUp(): void
    {
        $storage = vfsStream::setup('templates');
        $storage->addChild(vfsStream::newFile('template')->setContent('foo: {{foo}}'));
        $this->renderer = new TwigRendererAdapter(vfsStream::url('templates'));
    }
}
