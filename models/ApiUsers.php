<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "api_users".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $phone_number
 * @property string $agency
 * @property integer $centris_user_id
 * @property integer $active_listings
 * @property string $last_connection
 * @property string $system_status
 */
class ApiUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password', 'created_at', 'updated_at', 'first_name', 'last_name', 'email_address', 'phone_number', 'agency', 'centris_user_id', 'active_listings', 'last_connection', 'system_status'], 'required'],
            [['status', 'created_at', 'updated_at', 'centris_user_id', 'active_listings'], 'integer'],
            [['login', 'password'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'email_address', 'phone_number', 'agency', 'last_connection', 'system_status'], 'string', 'max' => 250],
            [['login'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_address' => 'Email Address',
            'phone_number' => 'Phone Number',
            'agency' => 'Agency',
            'centris_user_id' => 'Centris User ID',
            'active_listings' => 'Active Listings',
            'last_connection' => 'Last Connection',
            'system_status' => 'System Status',
        ];
    }

    public function beforeSave(){

        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        
        return parent::beforeSave(true);
    }
}
