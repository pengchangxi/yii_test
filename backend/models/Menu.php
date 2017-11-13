<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $icon
 * @property integer $status
 * @property string $remark
 * @property integer $sort
 * @property integer $pid
 * @property integer $level
 * @property integer $ismenu
 * @property integer $islog
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort', 'pid', 'level', 'ismenu', 'islog'], 'integer'],
            [['url', 'title', 'icon'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'title' => '节点名称',
            'icon' => 'Icon',
            'status' => '状态',
            'remark' => '备注',
            'sort' => '排序',
            'pid' => 'Pid',
            'level' => 'Level',
            'ismenu' => '是否菜单',
            'islog' => '是否日志',
        ];
    }
}
