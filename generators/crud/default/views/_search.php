<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var $this yii\web\View */
/* @var $generator prodex\yii\gii\generators\crud\Generator */

echo "<?php\n";
?>
/**
 * @var View $this
 * @var ActiveForm $form
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
*/

use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get'
    ]) ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
    <div class="form-group">
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Сбросить') ?>, ['index'], ['class' => 'btn btn-default']) ?>
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Найти') ?>, ['class' => 'btn btn-primary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end() ?>

</div>
