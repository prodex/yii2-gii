<?php

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var yii\web\View $this */
/* @var $generator prodex\yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent:behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ]
        ];

        return $behaviors;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Элемент добавлен.');
            return $this->redirect(['update', <?= $urlParams ?>]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Изменения сохранены.');
            return $this->redirect(['update', <?= $urlParams ?>]);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
        if ($model->remove()) {
            \Yii::$app->session->setFlash('success', 'Удаление прошло успешно.');
        }

        return $this->redirect(['index']);
    }

    /**
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return <?=                   $modelClass ?>
     * @throws NotFoundHttpException
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        $model = <?= $modelClass ?>::findOne(<?= $condition ?>);
        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
