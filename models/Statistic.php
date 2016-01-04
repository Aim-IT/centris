<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statistic".
 *
 * @property integer $id
 * @property string $update_time
 * @property string $table_list
 * @property integer $count_tables
 */
class Statistic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['update_time', 'table_list', 'count_tables'], 'required'],
            [['update_time'], 'safe'],
            [['table_list'], 'string'],
            [['count_tables'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'update_time' => 'Update Time',
            'table_list' => 'Table List',
            'count_tables' => 'Count Tables',
        ];
    }
}
