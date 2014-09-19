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
// Controller
Yii::$app->placer->createPlace('aside');
Yii::$app->placer->aside->push('block1', 'content');

// View1
Yii::$app->placer->aside->push('block2', 'content');

// ...

// Layout
Yii::$app->placer->aside->renderAll();
?>
```