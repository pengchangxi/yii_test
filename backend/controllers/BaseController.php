<?php

namespace backend\controllers;

use backend\models\Menu;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class BaseController extends Controller{

    //执行方法之前，执行的动作
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {//用户已登录
            $access = $this->get_menu();
            $session = Yii::$app->session;
            $session->set('access',$access);
            return true;
        }else{
            return $this->redirect('/site/login')->send();
        }
    }

    //获取主菜单
    protected function get_menu(){
        $modules = $roleMenu = $pmenu = array();
        $map['ismenu']=1;
        $map['status']=1;
        $roleid = Yii::$app->user->identity->role_id;
        //var_dump($roleid);exit();
        $menuModel = new Menu();
        $rs=$menuModel::find()->where($map)->asArray()->all();
        if($roleid == '1'){
            foreach($rs as $row){
                if($row['level'] == 1){
                    $modules[$row['pid']][] = $row;//子菜单分组
                }
                if($row['level'] == 0){
                    $pmenu[$row['id']] = $row;//二级父菜单
                }
            }
        }else{
            $menu = new Menu();
            $rs = $menu->getAccess($roleid);
            foreach($rs as $row){
                if($row['level'] == 1){
                    $modules[$row['pid']][] = $row;//子菜单分组
                }
                if($row['level'] == 0){
                    $pmenu[$row['id']] = $row;//二级父菜单
                }
            }
        }
        $keys = array_keys($modules);//导航菜单
        //var_dump($pmenu);exit();
        foreach($pmenu as $k => $val){
            if(in_array($k,$keys)){
                $val['submenu'] = $modules[$k];//子菜单
                $roleMenu[] = $val;
            }
        }
        return $roleMenu;
    }



    /**
     * ----------------------------------------------
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     * @param string $message 提示信息
     * @param bool $code 状态
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @access private
     * @return void
     * ----------------------------------------------
     */
    private function dispatchJump($message, $code = true, $jumpUrl = '', $ajax = false)
    {
        $jumpUrl = !empty($jumpUrl) ? (is_array($jumpUrl) ? Url::toRoute($jumpUrl) : $jumpUrl) : '';
        if (true === $ajax || Yii::$app->request->isAjax) {// AJAX提交
            $data = is_array($ajax) ? $ajax : array();
            $data['message'] = $message;
            $data['code'] = $code;
            $data['url'] = $jumpUrl;
            $this->ajaxReturn($data);
        }
        // 成功操作后默认停留1秒
        $waitSecond = 3;

        if ($code) { //发送成功信息
            $message = $message ? $message : '提交成功';// 提示信息
            // 默认操作成功自动返回操作前页面
            echo $this->renderFile(Yii::$app->params['action_success'], [
                'message' => $message,
                'waitSecond' => $waitSecond,
                'jumpUrl' => $jumpUrl,
            ]);
        } else {
            $message = $message ? $message : '发生错误了';// 提示信息
            // 默认发生错误的话自动返回上页
            $jumpUrl = "javascript:history.back(-1);";
            echo $this->renderFile(Yii::$app->params['action_error'], [
                'message' => $message,
                'waitSecond' => $waitSecond,
                'jumpUrl' => $jumpUrl,
            ]);
        }
        exit;
    }

    /**
     * ----------------------------------------------
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     * ----------------------------------------------
     */
    protected function success($message = '', $jumpUrl = '', $ajax = false)
    {
        $this->dispatchJump($message, true, $jumpUrl, $ajax);
    }

    /**
     * ----------------------------------------------
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     * -----------------------------------------------
     */
    protected function error($message = '', $jumpUrl = '', $ajax = false)
    {
        $this->dispatchJump($message, false, $jumpUrl, $ajax);
    }

    /**
     * ------------------------------------------------
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @return void
     * ------------------------------------------------
     */
    protected function ajaxReturn($data)
    {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data);

        exit;
    }
}