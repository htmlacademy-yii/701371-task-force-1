<?php

namespace frontend\models;

use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Expression;

class TaskFilter extends Model
{
    public $categories = [];
    public $myCity = null;
    public $withoutExecutor = null;
    public $remoteWork = null;
    public $period = 'all';
    public $search = null;

    public function applyFilters(ActiveQuery &$tasks): void
    {
        if ($this->categories) {
            $tasks->andWhere(['category_id' => $this->categories]);
        }

        if ($this->myCity) {
            $tasks->andWhere(['city_id' => $this->myCity]);
        }

        // TODO: ???
        if ($this->withoutExecutor) {
            $tasks->andWhere(['city_id' => $this->withoutExecutor]);
        }

        if ($this->remoteWork) {
            $tasks->andWhere(['executor_id' => $this->remoteWork]);
        }

        switch ($this->period) {
            case 'day':
                $tasks->andWhere(['>', 'created', new Expression(
                        'CURRENT_TIMESTAMP() - INTERVAL 1 DAY')]);
                break;

            case 'week':
                $tasks->andWhere(['>', 'created', new Expression(
                    'CURRENT_TIMESTAMP() - INTERVAL 7 DAY')]);
                break;

            case 'month':
                $tasks->andWhere(['>', 'created', new Expression(
                    'CURRENT_TIMESTAMP() - INTERVAL 30 DAY')]);
                break;
        }

        if ($this->search) {
            $tasks->andWhere("MATCH(task.description, task.title) 
                AGAINST ('$this->search')");
        }
    }

    public function attributeLabels(): array
    {
        return [
            'categories'        => 'Категории',
            'myCity'            => 'Мой город',
            'withoutExecutor'   => 'Без исполнителя',
            'remoteWork'        => 'Удаленная работа',
            'period'            => 'Дата',
            'search'            => 'Поиск по названию',
        ];
    }

    public function rules(): array
    {
        return [
            [['categories', 'myCity', 'withoutExecutor', 'remoteWork', 'date',
                'find'], 'safe'],

            [['myCity', 'withoutExecutor', 'remoteWork'], 'boolean'],
            [['find'], 'string']
        ];
    }
}
