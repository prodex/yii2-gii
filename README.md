Yii2 gii
========


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist prodex/yii2-gii "~1.0.0"
```

or add

```
"prodex/yii2-gii": "~1.0.0"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'crud' => [
                    'class' => 'prodex\yii\gii\generators\crud\Generator'
                ],
                'model' => [
                    'class' => 'prodex\yii\gii\generators\model\Generator'
                ]
            ],
        ],
        // ...
    ],
    // ...
];
```