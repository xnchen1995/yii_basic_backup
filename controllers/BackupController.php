<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2016/3/11 0011
 * Time: 16:19
 */
namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use app\models\MerchantUser;
require_once("../vendor/msm/CCPRestSmsSDK.php");

class BackupController extends Controller{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 4,
                'minLength' => 4,
            ],
        ];
    }

    public function actionIndex()
    {
        if(!\Yii::$app->user->isGuest){
            $this->redirect(Url::toRoute('admin/index'));
        }
        $model = new MerchantUser(['scenario'=>'login']);
        if($model->load(\Yii::$app->request->post())  && $model->login())
        {
            return $this->redirect(Url::toRoute('admin/index'));
        }
        else
        {
            return $this->render('index',[ 'model' => $model ] );
        }
    }

    public function actionRegister()
    {
        $model = new MerchantUser(['scenario'=>'register']);
        return $this->render('register',['model' => $model]);
    }
    public function actionSms()
    {
        $request = \Yii::$app->request;
        if($request->isPost)
        {
            $num = $request->post('num');

            $havephone= MerchantUser::findByPhone("$num");
            if($havephone)
            {
//              $this->sendSMS("$num",array('8888','10'),"1");
//                echo "have";
                $session = \Yii::$app->session;
                echo $session->isActive ? true :false;
            }
            else
            {
//                echo "null";
            }
        }

    }
    public function actionTest()
    {
        $request = \Yii::$app->request;
        $num = $request->post('num',15659675727);
        $havephone= MerchantUser::findByPhone("$num");
        if($havephone)
        {
            echo "have";
            $session = \Yii::$app->session;
            $session->open();
            if($session->isActive)
            {
//                $session->setTimeout(5);
                $session['phone'] ="$num";
                echo $session['phone'];
                echo "1";
//                $session->destroy();
                $session->close();
                sleep(15);
                $session->open();
                echo $session['phone'];
                echo "2";
                $session->close();
            }

//            if($session->isActive)
//            echo ($session->isActive ? "true" : "false");
//            print_r($session->isActive);
        }
        else
        {
//                echo "null";
        }
    }
    public function sendSMS($to,$datas,$tempId)
    {
        // 初始化REST SDK
//        global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
        $accountSid= '8a48b5515350d1e20153697b996e291e';

        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        $accountToken= '608252fbe83d4a46bce11c8079e909e4';

        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        $appId='aaf98f895350b6880153697d1aae28cb';

        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
        $serverIP='sandboxapp.cloopen.com';


        //请求端口，生产环境和沙盒环境一致
        $serverPort='8883';

        //REST版本号，在官网文档REST介绍中获得。
        $softVersion='2013-12-26';
        $rest = new \REST($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        // 发送模板短信
//        echo "Sending TemplateSMS to $to <br/>";
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
//            echo "result error!";
        }
        if($result->statusCode!=0) {
//            echo "error code :" . $result->statusCode . "<br>";
//            echo "error msg :" . $result->statusMsg . "<br>";
            //TODO 添加错误处理逻辑
        }else{
//            echo "Sendind TemplateSMS success!<br/>";
            // 获取返回信息
            $smsmessage = $result->TemplateSMS;
//            echo $smsmessage->
//            echo "dateCreated:".$smsmessage->dateCreated."<br/>";
//            echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
            echo $smsmessage->smsMessageSid;
            //TODO 添加成功处理逻辑
        }
    }


}