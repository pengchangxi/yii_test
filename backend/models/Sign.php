<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sign".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $sign_count
 * @property integer $last_sign_time
 * @property string $sign_history
 */
class Sign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'sign_count', 'last_sign_time'], 'integer'],
            [['sign_history'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'sign_count' => '连续签到次数',
            'last_sign_time' => '最后签到时间',
            'sign_history' => '签到历史',
        ];
    }
}
