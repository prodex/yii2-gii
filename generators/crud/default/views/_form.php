<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator prodex\yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

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

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin() ?>
    <?= "<?= \$form->errorSummary(\$model) ?>"?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . "->error(false) ?>\n\n";
    }
} ?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Добавить') ?> : <?= $generator->generateString('Сохранить') ?>, ['class' => 'btn btn-success']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end() ?>

</div>
