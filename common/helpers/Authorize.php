<?php

namespace common\helpers;
/**
 * 通用的树型类，可以生成任何树型结构
 */
class Authorize
{

    /**
     * 生成树型结构所需要的2维数组
     * @var array
     */
    public $arr = [];

    /**
     * 生成树型结构所需修饰符号，可以换成图片
     * @var array
     */
    public $icon = ['│', '├', '└'];
    public $nbsp = "&nbsp;";
    private $str = '';
    /**
     * @access private
     */
    public $ret = '';

    /**
     * 构造函数，初始化类
     * @param array 2维数组，例如：
     * array(
     *      1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目一'),
     *      2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目二'),
     *      3 => array('id'=>'3','pid'=>1,'name'=>'二级栏目一'),
     *      4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目二'),
     *      5 => array('id'=>'5','pid'=>2,'name'=>'二级栏目三'),
     *      6 => array('id'=>'6','pid'=>3,'name'=>'三级栏目一'),
     *      7 => array('id'=>'7','pid'=>3,'name'=>'三级栏目二')
     *      )
     * @return array
     */
    public function init($arr = [])
    {
        $this->arr = $arr;
        $this->ret = '';
        return is_array($arr);
    }

    /**
     * 得到父级数组
     * @param int
     * @return array
     */
    public function getParent($myId)
    {
        $newArr = [];
        if (!isset($this->arr[$myId]))
            return false;
        $pid = $this->arr[$myId]['pid'];
        $pid = $this->arr[$pid]['pid'];
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['pid'] == $pid)
                    $newArr[$id] = $a;
            }
        }
        return $newArr;
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    public function getChild($myId)
    {
        $newArr = [];
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {

                if ($a['pid'] == $myId) {
                    $newArr[$id] = $a;
                }
            }
        }

        return $newArr ? $newArr : false;
    }



    /**
     * 得到树型结构
     * @param int ID，表示获得这个ID下的所有子级
     * @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"
     * @param int 被选中的ID，比如在做树型下拉框的时候需要用到
     * @return string
     */
    public function getTree($myId, $str, $sid = 0, $adds = '', $str_group = '')
    {
        $number = 1;
        //一级栏目
        $child = $this->getChild($myId);

        if (is_array($child)) {
            $total = count($child);

            foreach ($child as $key => $value) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer   = $adds ? $adds . $j : '';
                $selected = $value['id'] == $sid ? 'selected' : '';
                $id       = 0;
                $nstr     = '';
                @extract($value);

                $parentId = $value['pid'];


                $parentId == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");

                $this->ret .= $nstr;
                $nbsp      = $this->nbsp;
                $this->getTree($id, $str, $sid, $adds . $k . $nbsp, $str_group);
                $number++;
            }
        }
        return $this->ret;
    }



}

