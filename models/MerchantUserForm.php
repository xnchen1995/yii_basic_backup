<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant_user".
 *
 * @property string $phone
 * @property string $password
 * @property string $storeName
 * @property string $nickName
 * @property integer $grade
 */
class MerchantUserForm extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['phone', 'password', 'storeName', 'nickName', 'grade'], 'required'],
            [['grade'], 'integer'],
            [['phone'], 'string', 'max' => 13],
            [['password'], 'string', 'max' => 21],
            [['storeName', 'nickName'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Phone',
            'password' => 'Password',
            'storeName' => 'Store Name',
            'nickName' => 'Nick Name',
            'grade' => 'Grade',
        ];
    }
}
