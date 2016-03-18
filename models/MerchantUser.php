<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "merchant_user".
 *
 * @property integer $phone
 * @property string $password
 * @property string $storeName
 * @property string $nickName
 * @property integer $grade
 */
class MerchantUser extends ActiveRecord implements IdentityInterface
{
//    $property 记住我
    public $rememberMe = false;
//    $property 验证码
    public $verifyCode;
//    $property 手机短信验证码
    public $smsVerifyCode;
    //$property 确认密码
    public $verifyPassword;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant_user';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => '手机号',
            'password' => '密码',
            'storeName' => '店铺名',
            'nickname' => '商家昵称',
            'grade' => '评分',
            'verifyCode' => '验证码',
            'smsVerifyCode' =>'短信验证码',
            'verifyPassword' =>'确认密码'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            通用去空格
            [['phone','grade','password','storeName','nickName','verifyCode','verifyPassword'],'trim'],     //remove non-breaking space
//            登录
            [['phone','password','verifyCode'],'required','on' => 'login','message' => '{attribute}不能为空'],           //necessary
            ['phone','match','pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}必须为1开头的11位手机号'],    //phone number
            ['password', 'string', 'length' => [4, 20],"message" =>'{attribute}必须大于4位'], //length
            ['password', 'validatePassword', 'on' => 'login'],      //call function named validatePassword()
            ['rememberMe','boolean','on'=>'login'],     //remember password  whether or not
            ['verifyCode','captcha','on' =>'login'],     //captcha
//            注册
            [['phone','smsVerifyCode','password','verifyPassword'],'required','on' => 'register','message' =>'{attribute}不能为空'],
//          还没写
//            ['smsVerifyCode','on' => 'register'],     //verify sms verifyCode
            ['verifyPassword','compare','compareAttribute' => 'password','on' =>'register','message' =>'两次输入的密码不一致，请重新输入'],  //Verify Password

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['phone','password','rememberMe','verifyCode'];
        $scenarios['register'] = ['phone','smsVerifyCode','password','verifyPassword'];
        return $scenarios;
    }

    //
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $phone = static::findByPhone($this->phone);
            if (!$phone || !($this->password === $phone->password)) {
                $this->addError($attribute, '用户名或者密码错误');
            }
        }
    }

    public function login(){
        if($this->validate())
        {
            return Yii::$app->user->login(static::findByPhone($this->phone),$this->rememberMe ? 3600*24*30 : 0);
        }
        else
        {
            return false;
        }
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
