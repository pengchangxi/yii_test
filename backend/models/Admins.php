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
 * @property string $realname
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
            [['password_hash'], 'required'],
            [['created_at', 'updated_at', 'last_login_time'], 'safe'],
            [['role_id', 'status', 'errornum'], 'integer'],
            [['username', 'email', 'realname', 'nickname'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 12],
            [['password_hash', 'auth_key'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 255],
            [['last_login_ip'], 'string', 'max' => 15],
            [['username'], 'unique'],
        ];
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
            'realname' => '真实姓名',
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

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($insert) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
                $this->auth_key = Yii::$app->security->generateRandomString();
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
