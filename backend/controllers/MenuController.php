<?php

namespace backend\controllers;

use Yii;
use backend\models\Menu;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\helpers\Tree;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends BaseController
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Menu();
        $dataProvider = $model->search();
        //var_dump($dataProvider);exit();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $pid = Yii::$app->request->get('pid', 0);
        $model = new Menu();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($model->validate()){
                $model->save();
                return ['code'=>true,'message'=>'添加成功','url'=>'index'];
            }else{
                return ['code'=>false,'message'=>array_values($model->getFirstErrors())[0]];
            }
        } else {
            $this->layout = 'popup.php';
            $model->pid = $pid;
            $arr = Menu::find()->asArray()->all();
            $treeObj = new Tree($arr);
            //var_dump($treeObj->getTree());exit();
            return $this->render('create', [
                'model' => $model,
                'treeArr' => $treeObj->getTree(),
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format=Response::FORMAT_JSON;//json返回
            if ($model->validate()){
                $model->save();
                return ['code'=>true,'message'=>'修改成功','url'=>'index'];
            }else{
                return ['code'=>false,'message'=>array_values($model->getFirstErrors()[0])];
            }
        } else {
            $this->layout = 'popup.php';
            $arr = Menu::find()->asArray()->all();
            $treeObj = new Tree($arr);
            return $this->render('update', [
                'model' => $model,
                'treeArr' => $treeObj->getTree(),
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
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
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
