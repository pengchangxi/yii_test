<?php

namespace backend\controllers;

use backend\models\Access;
use backend\models\Menu;
use Yii;
use backend\models\Role;
use backend\models\RoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        if ($model->load(Yii::$app->request->post()) ) {
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($model->validate()){
                $model->save();
                return ['code'=>true,'message'=>'添加成功','url'=>'index'];
            }else{
                return ['code'=>false,'message'=>array_values($model->getFirstErrors()[0])];
            }
        } else {
            $this->layout = 'popup.php';//定义一个新的模板
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) ) {
            Yii::$app->response->format=Response::FORMAT_JSON;//json返回
            if ($model->validate()){//表单验证
                $model->save();//这边简写了没有判断
                return ['code'=>true,'message'=>'修改成功','url'=>'index'];
            }else{
                return ['code'=>false,'message'=>array_values($model->getFirstErrors()[0])];
            }

        } else {
            $this->layout = 'popup.php';//定义一个新的模板
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $edit = $this->findModel($id)->delete();
        if ($edit){
            return ['code'=>true,'message'=>'删除成功'];
        }else{
            return ['code'=>false,'message'=>'删除失败'];
        }
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //角色授权
    public function actionAuthorize()
    {
        if (Yii::$app->request->post()) {
            $roleId = Yii::$app->request->get("id");
            if (!$roleId) {
                $this->error('需要授权的角色不存在！');
            }
            $accessModel = new Access();
            if (is_array(Yii::$app->request->post('menuId')) && count(Yii::$app->request->post('menuId')) > 0) {

                $accessModel::deleteAll(["role_id" => $roleId, 'type' => 'admin_url']);
                foreach ($_POST['menuId'] as $menuId) {
                    $menuModel = new Menu();
                    $menu = $menuModel::find()->select(['url'])->where(["id" => $menuId])->one();
                    if ($menu) {
                        $name   = $menu['url'];
                        Yii::$app->db->createCommand()->insert('access', [
                            'role_id' => $roleId,
                            'rule_name' => $name,
                            'type' =>'admin_url',
                        ])->execute();
                    }
                }
                $this->success("授权成功！",'index');
            } else {
                //当没有数据时，清除当前角色授权
                $accessModel::deleteAll(["role_id" => $roleId]);
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        }
        $access = new Access();
        $category = $access->authoirz();
        $this->layout = 'popup.php';//定义一个新的模板
        return $this->render('authorize', [
            'category' => $category,
        ]);
    }
}
