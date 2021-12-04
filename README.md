# Template Component
[![Source Code](https://img.shields.io/badge/source-frostaly/template-blue.svg)](https://github.com/frostaly/template)
[![Latest Version](https://img.shields.io/github/tag/frostaly/template.svg)](https://github.com/frostaly/template/releases)
[![CI Status](https://github.com/frostaly/template/workflows/Quality%20Assurance/badge.svg)](https://github.com/frostaly/template/actions?query=workflow%3A%22Quality+Assurance%22)
[![Software License](https://img.shields.io/badge/license-GPL-brightgreen.svg)](https://github.com/frostaly/template/LICENSE)

The Template component provides a simple interface to interact with multiple templating libraries.

## Getting Started

```
$ composer require frostaly/template
```

```php
use Frostaly\Template\Renderers\PlatesTemplateRenderer;
use Frostaly\Template\Renderers\TwigTemplateRenderer;
use Frostaly\Template\TemplateEngine;

// Using the default namespace
$defaultRenderer = new PlatesTemplateRenderer('path/to/views');
$templateEngine = new TemplateEngine($defaultRenderer);
echo $templateEngine->render('welcome', ['title' => 'frostaly']);

// Using the frostaly namespace
$twigRenderer = new TwigTemplateRenderer('path/to/frostaly');
$templateEngine->setRenderer($twigRenderer, 'frostaly');
echo $templateEngine->render('frostaly::home');
```

## Current Adapters
The component provides renderers for the following libraries.
* [Twig](https://twig.symfony.com/) - from the symfony framework
* [Latte](https://latte.nette.org/) - from the Nette framework
* [Plates](https://platesphp.com/) - from the PHP League
