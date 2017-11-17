<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admins".
 *
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $mobile
 * @property string $password
 * @property string $nickname
 * @property string $password_hash
 * @property string $auth_key
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 * @property integer $role_id
 * @property integer $status
 * @property string $last_login_ip
 * @property string $last_login_time
 * @property integer $errornum
 */
class Admins extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'unique'],
            ['username','required'],
            ['email','email'],
            [['created_at', 'updated_at', 'last_login_time'], 'safe'],
            [['role_id', 'status', 'errornum'], 'integer'],
            [['username', 'email', 'realname', 'nickname'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 12],
            [['password_hash', 'auth_key'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 255],
            [['last_login_ip'], 'string', 'max' => 15],
            [['password'], 'required', 'on' => ['create']],
            ['role_id','required']

        ];
    }

    public function attributes(){
        //添加属性
        return array_merge(parent::attributes(),['password']);
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'email', 'password'];
        $scenarios['update'] = ['username', 'email', 'password'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'email' => 'Email',
            'mobile' => '手机',
            'password' => '密码',
            'nickname' => '昵称',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'avatar' => '头像',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'role_id' => '角色',
            'status' => '状态',
            'last_login_ip' => '最后登录IP',
            'last_login_time' => '最后登录时间',
            'errornum' => '错误次数',
        ];
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * 生成加密后的密码
     * @param [string] $password [用户密码]
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 生成auth_key
     * @return [type] [description]
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    //保存之前执行的方法
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if ($this->password){
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }
            unset($this->password);
            if($insert) {
                $this->created_at = time();
            }
            else {
                $this->updated_at = time();
            }
            return true;
        }else {
            return false;
        }
    }
}
