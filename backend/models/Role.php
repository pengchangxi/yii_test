<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $name
 * @property integer $branch_id
 * @property integer $status
 * @property string $desc
 *
 * @property Branch $branch
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'status'], 'integer'],
            [['name', 'desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '角色名称',
            'status' => '状态',
            'desc' => '备注',
        ];
    }

}
