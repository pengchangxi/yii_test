<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\helpers\Tree;
use yii\caching\Cache;


/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $url
 * @property string $name
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
            [['url', 'name', 'icon'], 'string', 'max' => 50],
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
            'name' => '节点名称',
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

    public function beforeSave($insert){
        if(parent::beforeSave($insert)) {
            if($insert) {
                $pmenu = Menu::find()->where(['id'=>$this->pid])->one();
                $this->level = $pmenu ? $pmenu->level + 1 : 0;//在父级级别的基础上+1
            }
            else {
                //$this->updated_at = date('Y-m-d H:i:s');
            }
            return true;
        }else {
            return false;
        }
    }

    public function search()
    {
        $query = Menu::find();

        $arr = $query->asArray()->all();
        $treeObj = new Tree(\yii\helpers\ArrayHelper::toArray($arr));
        $treeObj->icon = ['&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $treeObj->nbsp = '&nbsp;&nbsp;&nbsp;';
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $treeObj->getGridTree(),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $dataProvider;
    }

    /**
     * 更新缓存
     * @param  $data
     * @return array
     */
    public function menuCache($data = null)
    {
        $cache = Yii::$app->cache;
        if (empty($data)) {
            $data = Menu::find()->asArray()->all();
            $cache->set('Menu', $data,0);
        } else {
            $cache->set('Menu', $data,0);
        }
        return $data;
    }

    // 获取订单所属用户
    public function getAccess($roleId)
    {
        //同样第一个参数指定关联的子表模型类名
        //return $this->hasOne(Access::className(), ['url' => 'rule_name']);
        $data = Menu::find()
            ->leftJoin('access','menu.url=access.rule_name' )
            ->where(['access.role_id' => $roleId,'menu.status'=>1])
            //->orderBy(['user_comm.count_praise' => SORT_DESC])
            ->asArray()->all();
        return $data;

    }
}
