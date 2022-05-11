<?php

declare(strict_types=1);

namespace Frostaly\Template\Tests\Adapters;

use Frostaly\Template\Adapters\PlatesRendererAdapter;
use org\bovigo\vfs\vfsStream;

class PlatesRendererAdapterTest extends AbstractRendererTest
{
    protected function setUp(): void
    {
        $storage = vfsStream::setup('templates');
        $storage->addChild(vfsStream::newFile('template')->setContent('foo: <?=$this->e($foo)?>'));
        $this->renderer = new PlatesRendererAdapter(vfsStream::url('templates'));
    }
}
