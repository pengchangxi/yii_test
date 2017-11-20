<?php

namespace backend\controllers;

class IndexController extends BaseController
{


    public function actionIndex(){
        return $this->render('index');

    }
}