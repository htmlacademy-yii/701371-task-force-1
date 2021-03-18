<?php

namespace frontend\models\forms;

use yii\base\Model;
use frontend\models\Users;


/**
 * @note
 * form for login user
 *
 * Class LoginForm
 * @package frontend\models\forms
 */
class LoginForm extends Model
{
    public $email;
    public $password;

    private $userBuffer;

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    /**
     * @note
     * we receive the user by email
     *
     * @return Users|null
     */
    public function getUser(): ?Users
    {
        if ($this->userBuffer === null) {
            $this->userBuffer = Users::findOne(['email' => $this->email]);
        }

        return $this->userBuffer;
    }

    /**
     * @note
     * for validation user password
     *
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email / пароль');
            }
        }
    }
}
