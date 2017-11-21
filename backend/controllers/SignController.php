<?php

namespace backend\controllers;

use backend\models\SignLog;
use Yii;
use backend\models\Sign;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SignController implements the CRUD actions for Sign model.
 */
class SignController extends BaseController
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
     * Lists all Sign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Sign::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sign model.
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
     * Creates a new Sign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sign();
        $uid = Yii::$app->user->identity->id;
        $model->uid = $uid;
        $model->last_sign_time = strtotime(date("Y-m-d",time()));
        $sign_history = array(strtotime(date("Y-m-d",time())));
        $model->sign_history =json_encode($sign_history,true);
        $sign = Sign::find()->where(['uid'=>$uid])->one();
        if ($sign){//之前有签到过
            $today = strtotime(date("Y-m-d",time()));//当前时间
            if ($today==$sign['last_sign_time']){
                $this->error('不能重复签到');
            }
            $history = json_decode($sign['sign_history']);
            array_push($history,$today);//在历史签到中插入一条数据
            $sign->sign_history = json_encode($history,true);
            if (round(($today-$sign['last_sign_time'])/3600/24)<=1){//判断是否为连续签到
                $sign->sign_count = $sign['sign_count'] + 1;
                if ($sign->sign_count==2){
                    $integral = 10;
                }else if ($sign->sign_count==3){
                    $integral = 15;
                }else if ($sign->sign_count>=4){
                    $integral = 20;
                }else {
                    $integral = 5;
                }
            }else{
                $integral = 5;
                $sign->sign_count = 1;
            }
            $signLog = new SignLog();
            $sign->last_sign_time = $today;
            if ($sign->save()){
                $signLog->addLog($uid,$integral);
                $this->success('签到成功','index');
            }else{
                $this->error('签到失败');
            }
        }else{
            $model->sign_count = 1;
            if ($model->save()){
                $signLog = new SignLog();
                $integral = 5;
                $signLog->addLog($uid,$integral);
                $this->success('签到成功','index');
            }else{
                $this->error('签到失败');
            }
        }
    }



    /**
     * Updates an existing Sign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
