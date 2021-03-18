<?php

namespace frontend\controllers;

use frontend\models\Category;
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
}
