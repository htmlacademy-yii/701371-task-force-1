<?php

namespace frontend\models;

use yii\base\Model;

class UserSignupForm extends Model
{
    public $email;
    public $name;
    public $city;
    public $password;

    public function attributeLabels()
    {
        return [
            'email' => 'Почта',
            'name' => 'Логин',
            'city' => 'Город проживания',
            'password' => 'Пароль',
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->email = $this->email;
        $user->name = $this->name;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
    }

    // TODO: think about it
    //protected function sendEmail($user)
    //{
    //    return Yii::$app
    //        ->mailer
    //        ->compose(
    //            ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
    //            ['user' => $user]
    //        )
    //        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
    //        ->setTo($this->email)
    //        ->setSubject('Account registration at ' . Yii::$app->name)
    //        ->send();
    //}

    public function rules()
    {
        return [
            [['email', 'name', 'city', 'password'], 'safe', 'required'],
            [['email'], 'email', 'unique'],
            [['city'], 'integer', 'exist'],
            [['email', 'name', 'password'], 'string', 'max' => 64],
            [['name'], 'min' => 2],
            [['password'], 'min' => 8]
        ];
    }
}
