<?php


namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Task;

class LandingController extends Controller
{
    private const CARDS_AMOUNT = 4;

    // NOTE: ...index.php?r=landing
    public function actionIndex()
    {
        $this->layout = 'landing';

        $tasks = Task::find()
            ->orderBy(['created' => SORT_ASC])
            ->limit(4)
            ->all();

        return $this->render('index', compact('tasks'));
    }
}