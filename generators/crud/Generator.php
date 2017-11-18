<?php

namespace prodex\yii\gii\generators\crud;

use \yii\gii\generators\crud\Generator;

/**
 * Generates CRUD
 *
 * @see Generator
 */
class Generator extends Generator
{
    /**
     * @var string[]
     */
    public $excludeColumnsFromForm = ['created_at', 'create_time', 'updated_at', 'create_time'];

    /**
     * @inheritdoc
     */
    public function getColumnNames()
    {
        $columnNames = parent::getColumnNames();
        $columnNames = array_diff($columnNames, $this->excludeColumnsFromForm);

        return $columnNames;
    }
}
