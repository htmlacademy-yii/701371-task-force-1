<?php


namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\UserSignupForm;
use frontend\models\City;

class SignupController extends Controller
{
    public function actionIndex(): string
    {
        $user = new UserSignupForm();
        $cities = City::find()->orderBy(['title' => SORT_ASC])->all();

        if (Yii::$app->request->getIsPost()) {
            $user->load(Yii::$app->request->post());
            if (!$user->validate()) {
                $errors = $user->getErrors();
                var_dump($errors);
                die;
            }
        }

        return $this->render('index', compact('user'));
    }
}
