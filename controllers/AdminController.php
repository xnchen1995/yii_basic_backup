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


class AdminController extends Controller
{
    public $layout='admin';
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionChangepwdpage()
    {
        $model = new MerchantUser(['scenario'=>'']);
    }
}