<?php

namespace prodex\yii\gii\generators\crud;

/**
 * Generates CRUD
 *
 * @see \yii\gii\generators\crud\Generator
 */
class Generator extends \yii\gii\generators\crud\Generator
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
