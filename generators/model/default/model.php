<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */


$behaviors = [];

$columns = array_column($tableSchema->columns, 'name');
$timestampBehaviors = [
    'createdAtAttribute' => ['created_at', 'create_time'],
    'updatedAtAttribute' => ['updated_at', 'update_time'],
];

$timestampBehaviorsStrings = [];
$timestampNeeded = false;
foreach ($timestampBehaviors as $key => $properties) {
    $propertyExists = false;
    foreach ($properties as $propertyIndex => $propertyName) {
        if (in_array($propertyName, $columns, true)) {
            $timestampNeeded = true;
            $propertyExists = true;
            if ($propertyIndex != 0) {
                $timestampBehaviorsStrings[] = "'{$key}' => '{$propertyName}'";
                break;
            }
        }
    }

    if (!$propertyExists) {
        $timestampBehaviorsStrings[] = "'{$key}' => false";
    }
}

if ($timestampNeeded) {
    $behaviors['timestamp'] = array_merge([
        "'class' => TimestampBehavior::class"
    ], $timestampBehaviorsStrings);
}

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
<?= isset($behaviors['timestamp']) ? "use yii\\behaviors\\TimestampBehavior;\n": '' ?>

/**
* This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
*
<?php foreach ($tableSchema->columns as $column): ?>
    * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach ?>
<?php if (!empty($relations)): ?>
    *
    <?php foreach ($relations as $name => $relation): ?>
        * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
    <?php endforeach ?>
<?php endif ?>
*/
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
/**
* @inheritdoc
*/
public static function tableName()
{
return '<?= $generator->generateTableName($tableName) ?>';
}
<?php if ($generator->db !== 'db'): ?>

    /**
    * @return \yii\db\Connection the database connection used by this AR class.
    */
    public static function getDb()
    {
    return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif ?>

/**
* @inheritdoc
*/
public function rules()
{
return [<?= "\n            " . implode(",\n            ", $rules) . ",\n        " ?>];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
<?php foreach ($labels as $name => $label): ?>
    <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach ?>
];
}
<?php foreach ($relations as $name => $relation): ?>

    /**
    * @return \yii\db\ActiveQuery
    */
    public function get<?= $name ?>()
    {
    <?= $relation[0] . "\n" ?>
    }
<?php endforeach ?>
<?php if ($queryClassName): ?>
    <?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
    ?>
    /**
    * @inheritdoc
    * @return <?= $queryClassFullName ?> the active query used by this AR class.
    */
    public static function find()
    {
    return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif ?>

<?php if ($behaviors): ?>
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
    return [
    <?php foreach ($behaviors as $key => $value): ?>
        '<?= $key ?>' => [
        <?= implode(",\n" . str_repeat('    ', 4), $value) . "\n" ?>
        ],
    <?php endforeach ?>
    ];
    }
<?php endif ?>
}
