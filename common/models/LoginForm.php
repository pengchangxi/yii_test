<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username password and verifyCode are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['verifyCode', 'captcha'],//验证码必须正确
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    //后面的是前面的注释，在rules验证的时候，如果报错，会把此处的后面的内容显示出来
    public function attributeLabels(){
        return [
            'username'    => '账号',
            'password'    => '密码',
            'verifyCode'    =>'验证码',
            'rememberMe'  => '记住密码',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误！');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     * 根据用户名查询用户信息
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Admins::findByUsername($this->username);

        }
        return $this->_user;
    }
}
