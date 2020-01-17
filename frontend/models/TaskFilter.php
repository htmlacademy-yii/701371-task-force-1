<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


class TaskFilter extends ActiveRecord
{
    public $categories = [];
    public $myCity = null;
    public $withoutExecutor = null;
    public $remoteWork = null;
    public $period = 'all';
    public $search = null;

    public function applyFilters(ActiveQuery $tasks): ActiveQuery
    {
        if ($this->categories) {
            $tasks->andWhere(['category_id' => $this->categories]);
        }
    }

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'myCity' => 'Мой город',
            'withoutExecutor' => 'Без исполнителя',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Дата',
            'search' => 'Поиск по названию',
        ];
    }

    public function rules()
    {
        return [
            [[
                'categories',
                'myCity',
                'withoutExecutor',
                'remoteWork',
                'date',
                'find'
            ], 'safe']
        ];
    }
}
