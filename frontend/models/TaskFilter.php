<?php

namespace frontend\models;

use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Expression;


/**
 * @note
 * filter for tasks
 *
 * Class TaskFilter
 * @package frontend\models
 */
class TaskFilter extends Model
{
    /** @var array */
    public $categories;

    public $withoutExecutor;
    public $remoteWork;
    public $period;

    /** @note for search */
    public $title;

    const TIME_PERIOD_ALL = 'all';
    const TIME_PERIOD_DAY = 'day';
    const TIME_PERIOD_WEEK = 'week';
    const TIME_PERIOD_MONTH = 'month';

    const TIME_PERIODS = [
        self::TIME_PERIOD_DAY => 1,
        self::TIME_PERIOD_WEEK => 7,
        self::TIME_PERIOD_MONTH => 30
    ];

    const TIME_PERIODS_TITLES = [
        self::TIME_PERIOD_DAY => 'За день',
        self::TIME_PERIOD_WEEK => 'За неделю',
        self::TIME_PERIOD_MONTH => 'За месяц'
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['categories', 'myCity', 'withoutExecutor', 'remoteWork', 'date',
                'title'], 'safe'],

            [['myCity', 'withoutExecutor', 'remoteWork'], 'boolean'],
            [['title'], 'filter', 'filter' => 'htmlspecialchars'],
            [['title'], 'string']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'categories' => 'Категории',
            'myCity' => 'Мой город',
            'withoutExecutor' => 'Без исполнителя',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'search' => 'Поиск по названию',
        ];
    }

    /**
     * @note
     * filter implementation
     *
     * @param ActiveQuery $tasks
     */
    public function applyFilters(ActiveQuery $tasks): void
    {
        if ($this->categories) {
            $tasks->andWhere(['category_id' => $this->categories]);
        }

        if ($this->withoutExecutor) {
            $tasks->andWhere(['executor_id' => NULL]);
        }

        if ($this->period) {
            $tasks->andWhere(['> created', new Expression(
                sprintf( ('CURRENT_TIMESTAMP() - INTERVAL %d DAY'),
                    self::TIME_PERIODS[$this->period]) )
            ]);
        }

        if ($this->title) {
            $tasks->andWhere(['LIKE', 'title', $this->title]);
        }
    }
}
