<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sign_log".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $create_at
 * @property integer $integral
 */
class SignLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sign_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'create_at', 'integral'], 'integer'],
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
            'create_at' => 'Create At',
            'integral' => 'Integral',
        ];
    }

    //签到记录
    public function addLog($uid,$integral){
        $model = new SignLog();
        $model->create_at = time();
        $model->uid = $uid;
        $model->integral = $integral;
        return $model->save();
    }
}
