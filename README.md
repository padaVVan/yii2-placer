Placer
======
Добавление виджетов в коллекции, вывод рендеринг коллекций в определенных местах шаблона

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist padavvan/yii2-placer "*"
```

or add

```
"padavvan/yii2-placer": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php

use padavvan\placer\Portlet;
use padavvan\placer\Collection;
use padavvan\placer\RouteDependency;

$portlet1 = new Portlet(['name' => 'portlet1', 'content' => '#1 Portlet']);
$portlet2 = new Portlet(['name' => 'portlet2', 'content' => '#2 Portlet']);
$portlet2->wrap('section', ['class' => 'portlet']);
$portlet3 = new Portlet(['name' => 'portlet3', 'content' => '#3 Portlet']);

// main collection
$placer = new Collection('placer');

$subTop = Collection::create(['name' => 'subTop']);
$subTop
	->push($portlet1)
	->push($portlet2)
	->wrap('div', ['class' => 'well']);

$top = new Collection(['name' => 'top', 'tag' => 'section']);
$top->push($portlet3);
$top->push($subTop);

$bottom = new Collection(['name' => 'bottom', 'tag' => 'div', 'options' => ['class' => 'footer']]);
$bottom->dependency = [
	// view on site/about, site/info, etc
	new RouteDependency('/site/*'),
	// and not view on site/contacts
	new RouteDependency('/site/contacts', true)
	];

$bottom->push($portlet1);

$placer->push($top);
$placer->push($bottom);

echo $placer->render();
// or
echo $placer->top->render();
echo $placer->bottom->render();
```