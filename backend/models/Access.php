<?php

namespace backend\models;

use common\helpers\Authorize;
use Yii;

/**
 * This is the model class for table "access".
 *
 * @property string $id
 * @property string $role_id
 * @property string $rule_name
 * @property string $type
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            [['role_id'], 'integer'],
            [['rule_name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'rule_name' => 'Rule Name',
            'type' => 'Type',
        ];
    }

    public function authoirz(){
        //$AuthAccess     = new Access();
        $adminMenuModel = new Menu();
        //角色ID
        $roleId = Yii::$app->request->get('id');

        $tree       = new Authorize();
        $tree->icon = ['│ ', '├─ ', '└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        $result = $adminMenuModel->menuCache();
        //var_dump($result);exit();

        $newMenus      = [];
        //$privilegeData = $AuthAccess->where(["role_id" => $roleId])->column("rule_name");//获取权限表数据
        $privilegeData = Access::find()->where(["role_id" => $roleId])->select(['rule_name','id'])->all();

        foreach ($result as $m) {
            $newMenus[$m['id']] = $m;
        }

        foreach ($result as $n => $t) {
            $result[$n]['checked']      = ($this->_isChecked($t, $privilegeData)) ? ' checked' : '';
            $result[$n]['level']        = $this->_getLevel($t['id'], $newMenus);
            $result[$n]['style']        = empty($t['pid']) ? '' : 'display:none;';
            $result[$n]['parentIdNode'] = ($t['pid']) ? ' class="child-of-node-' . $t['pid'] . '"' : '';
        }

        $str = "<tr id='node-\$id'\$parentIdNode  style='\$style'>
                   <td style='padding-left:10px;'>\$spacer<input type='checkbox' name='menuId[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
    			</tr>";
        $tree->init($result);
        var_dump($result);exit();

        $category = $tree->getTree(0, $str);
        var_dump($category);exit();

        return $category;
    }

    /**
     * 检查指定菜单是否有权限
     * @param array $menu menu表中数组
     * @param $privData
     * @return bool
     */
    private function _isChecked($menu, $privData)
    {
        $name   = $menu['url'];
        if ($privData) {
            if (in_array($name, $privData)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * 获取菜单深度
     * @param $id
     * @param array $array
     * @param int $i
     * @return int
     */
    protected function _getLevel($id, $array = [], $i = 0)
    {
        if ($array[$id]['pid'] == 0 || empty($array[$array[$id]['pid']]) || $array[$id]['pid'] == $id) {
            return $i;
        } else {
            $i++;
            return $this->_getLevel($array[$id]['pid'], $array, $i);
        }
    }
}
