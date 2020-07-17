<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class SignupForm extends Model
{
    public $email;
    public $name;
    public $city;
    public $password;

    public function attributeLabels(): array
    {
        return [
            'email' => 'Почта',
            'name' => 'Имя',
            'city' => 'Город проживания',
            'password' => 'Пароль',
        ];
    }

    public function rules(): array
    {
        return [
            [['email', 'name', 'city', 'password'], 'required'],
            [['email', 'name', 'city', 'password'], 'safe'],

            [['email'], 'email'],

            [['city'], 'integer'],

            [['email', 'name', 'password'], 'string', 'max' => 64],

            [['name'], 'string', 'min' => 2],
            [['name'], 'trim'],
            [['email'], 'string', 'min' => 3],
            [['password'], 'string', 'min' => 8]
        ];
    }

    public function createUser()
    {
        $user = new Users();
        $user->name = $this->name;
        $user->email =$this->email;
        $user->password =
            Yii::$app
                ->security
                ->generatePasswordHash($this->password);

        if (!$user->save()) {
            if ($user->hasErrors('email')) {
                $this->addError('email', 'email занят');
            }
            return null;
        }

        return $user;
    }
}
