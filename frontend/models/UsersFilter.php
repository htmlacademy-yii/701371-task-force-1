<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class UsersFilter extends Model
{
    public $categories;
    public $isFree;
    public $isOnline;
    public $haveReview;
    public $userName;

    public function rules(): array
    {
        return [
            [['categories', 'isFree', 'isOnline', 'haveReview'], 'safe'],
            [['isFree', 'isOnline', 'haveReview'], 'boolean'],
            [['userName'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'categories' => 'Категории',
            'isFree' => 'Сейчас свободен',
            'isOnline' => 'Сейчас онлайн',
            'haveReview' => 'Есть отзывы',
            'search' => 'Поиск по названию',
        ];
    }

    public function getDataProvider(): ActiveDataProvider
    {
        $query = Users::find()->alias('u');

        /**
         * @note
         * us
         * this is alias of - UserSpecialization::tableName()
         */
        if ($this->categories) {
            $query->join('INNER JOIN', UserSpecialization::tableName() . ' us', 'us.user_id = u.id')
                ->andWhere(['us.category_id' => $this->categories])
                ->groupBy('u.id');
        }

        /**
         * @note
         * having - filtering is given after the query is executed-runs on the
         * result and removes those lines that do not fit the condition
         */
        if ($this->isFree) {
            $query->join(
                'LEFT JOIN',
                Task::tableName() . ' t', 't.executor_id = u.id AND t.status_id = :statusId',
                [
                    'statusId' => Task::STATUS_WORK,
                ]
            )
                ->groupBy('u.id')
                ->having('COUNT(t.id) = 0');
        }

        /**
         * @note
         * SQL query,
         * current time minus 5 minutes
         *
         * SELECT NOW() - INTERVAL 5 MINUTE
         */
        if ($this->isOnline) {
            $query->andWhere('u.visit >= NOW() - INTERVAL 5 MINUTE');
        }

        if ($this->haveReview) {
            $query->join('INNER JOIN', Reviews::tableName() . ' r', 'r.account_id = u.id')
                ->groupBy('u.id');
        }

        if ($this->userName) {
            $query->andWhere(['LIKE', 'u.name', $this->userName])
                ->groupBy('u.id');
        }

        /**
         * @note
         * query - default value of DataProvider, for AQ instance
         * query - must have always is DB::find...
         */
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    }
}
