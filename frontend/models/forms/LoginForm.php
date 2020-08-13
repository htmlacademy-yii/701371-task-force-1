<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use frontend\models\Users;

class LoginForm extends Model
{
    private $userBuffer;

    public $email;
    public $password;

    public function attributeLabels(): array
    {
        return [
            'email' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'safe'],

            [['email'], 'email'],

            [['email', 'password'], 'string', 'max' => 64],

            [['email'], 'trim'],
            [['email'], 'string', 'min' => 3],
            [['password'], 'string', 'min' => 8]
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email / пароль');
            }
        }
    }

    public function getUser()
    {
        if ($this->userBuffer === null) {
            $this->userBuffer = Users::findOne(['email' => $this->email]);
        }

        return $this->userBuffer;
    }
}
