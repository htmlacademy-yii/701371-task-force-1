<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use DateTime;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $address
 * @property float $price
 * @property string $deadline
 * @property string $created
 * @property int|null $city_id
 * @property int|null $executor_id
 * @property int|null $status_id
 * @property int|null $category_id
 *
 * @property Feedback[] $feedbacks
 * @property Category $category
 * @property Users $executor
 * @property City $city
 * @property TaskStatus $status
 * @property TaskFile[] $taskFiles
 */
class Task extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'task';
    }

    public function getPublishedTimeDiff(): string
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($this->created);
        $interval = $currentDate->diff($createDate);
        return (int)$interval->d . ' дней и ' . $interval->h . ' часа';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title',
                'description',
                'address',
                'price',
                'deadline'], 'required'
            ],
            [['description'], 'string'],
            [['price'], 'number'],
            [['deadline', 'created'], 'safe'],
            [['city_id', 'executor_id', 'status_id', 'category_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
            [['executor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['executor_id' => 'id']
            ],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['city_id' => 'id']
            ],
            [['status_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => TaskStatus::className(),
                'targetAttribute' => ['status_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'address' => 'Address',
            'price' => 'Price',
            'deadline' => 'Deadline',
            'created' => 'Created',
            'city_id' => 'City ID',
            'executor_id' => 'Executor ID',
            'status_id' => 'Status ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFeedbacks(): ActiveQuery
    {
        return $this->hasMany(Feedback::className(), ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(TaskStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTaskFiles(): ActiveQuery
    {
        return $this->hasMany(TaskFile::className(), ['task_id' => 'id']);
    }
}
