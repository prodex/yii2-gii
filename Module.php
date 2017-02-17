<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace prodex\yii\gii;

use Yii;

/**
 * This is the main module class for the Gii module.
 *
 * To use Gii, include it as a module in the application configuration like the following:
 *
 * ~~~
 * return [
 *     'bootstrap' => ['gii'],
 *     'modules' => [
 *         'gii' => ['class' => 'prodex\yii\gii'],
 *     ],
 * ]
 * ~~~
 *
 */
class Module extends \yii\gii\Module
{
    public $generators = [
        'crud' => [
            'class' => 'yii\gii\generators\crud\Generator'
        ]
    ];
}
