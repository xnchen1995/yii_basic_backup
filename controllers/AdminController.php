<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2016/3/24 0024
 * Time: 19:40
 */

namespace app\controllers;

use app\models\MerchantUser;
use Yii;
use yii\web\Controller;
use \yii\helpers\Url;
use yii\web\Response;

class AdminController extends Controller
{
    public $layout='admin';
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionChangepwdpage()
    {
        $model = new MerchantUser(['scenario'=>'changePwd']);
        return $this->render('changepwdpage',['model'=>$model]);
    }
    public function actionChangepwd()
    {
        $result = array();
        $result['status'] = 1;
        $result['message'] = '保存成功，请重新登录';
        $result['url'] = Url::toRoute('site/logout');
        return $this->renderJson($result);
    }
    public function renderJson($params = array()) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }
}