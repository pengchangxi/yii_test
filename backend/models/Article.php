<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $thumb
 * @property string $content
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['create_time', 'update_time', 'status'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['thumb'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'thumb' => 'Thumb',
            'content' => 'Content',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
