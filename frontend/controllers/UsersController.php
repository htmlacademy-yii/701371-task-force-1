<?php

namespace frontend\controllers;

use frontend\models\Category;
use frontend\models\Task;
use frontend\models\TaskRespond;
use frontend\models\Users;
use frontend\models\UsersFilter;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * @note
 * class for working with user's
 *
 * Class UsersController
 * @package frontend\controllers
 */
class UsersController extends SecuredController
{
    /**
     * @note
     * for view users
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $userFilter = new UsersFilter();
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        $userFilter->load(Yii::$app->request->get());

        return $this->render('index', [
            'categories' => $categories,
            'userFilter' => $userFilter,
            'dataProvider' => $userFilter->getDataProvider(),
        ]);
    }


    public function actionView($id)
    {
        /**
         * @var Users $user
         */
        $user = Users::find()
            ->where(['id' => $id])
            ->one();

        $userTasks = Task::find()
            ->where(['owner_id' => $id])
            ->all();

        $userResponds = TaskRespond::find()
            ->where(['user_id' => $id])
            ->all();

        $userRespond = TaskRespond::find()
            ->where(['user_id' => $id])
            ->one();

        if ($user === null) {
            throw new NotFoundHttpException('Такого пользователя не найдено');
        }

        $userBorn = date('Y', strtotime($user->born));
        $currentYear = date('Y');
        $userAge = $currentYear - $userBorn;

//        $contact = UsersContacts::find()->where(['account_id' => 21])->one();
//        var_dump($user->contacts->phone); die();

        return $this->render('view',
            compact(
                'user',
                'userAge',
                'userTasks',
                'userResponds',
                'userRespond'
            )
        );
    }
}
