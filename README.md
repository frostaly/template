# Template Component

<img src="https://avatars.githubusercontent.com/u/95505865" alt="" align="left" height="64">

The template component provides a simple interface to interact with multiple templating libraries.

[![Source Code](https://img.shields.io/badge/source-frostaly/template-blue.svg)](https://github.com/frostaly/template)
[![CI Status](https://github.com/frostaly/template/workflows/Build/badge.svg)](https://github.com/frostaly/template/actions?query=workflow%3A%22Build%22)
[![Code Quality](https://scrutinizer-ci.com/g/frostaly/template/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/frostaly/template/?branch=master)
[![Software License](https://img.shields.io/badge/license-GPL-brightgreen.svg)](https://github.com/frostaly/template/blob/master/LICENSE)


## Requirements
- This library requires PHP 8.0 or later.

## Installation

This library is installable via [composer](https://getcomposer.org/):

```
$ composer require frostaly/template
```

## Quickstart
Using the default namespace:

```php
use Frostaly\Template\Adapters\PlatesRendererAdapter;
use Frostaly\Template\TemplateEngine;
use Frostaly\Template\TemplateRenderer;

$defaultRenderer = new TemplateRenderer(new PlatesRendererAdapter('path/to/views'));
$templateEngine = new TemplateEngine($defaultRenderer);
echo $templateEngine->render('welcome', ['title' => 'frostaly']);
```
Using a custom namespace:

```php
use Frostaly\Template\Adapters\TwigRendererAdapter;
use Frostaly\Template\TemplateEngine;
use Frostaly\Template\TemplateRenderer;

$templateEngine = new TemplateEngine();
$twigRenderer = new TemplateRenderer(new TwigRendererAdapter('path/to/views'));
$templateEngine->setRenderer($twigRenderer, 'frostaly');
echo $templateEngine->render('frostaly::home');
```

## Current Adapters
The component provides adapters for the following libraries.
* [Twig](https://twig.symfony.com/) - from the Symfony framework
* [Latte](https://latte.nette.org/) - from the Nette framework
* [Plates](https://platesphp.com/) - from the PHP League
