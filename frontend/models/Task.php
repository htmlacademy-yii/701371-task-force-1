<?php

namespace frontend\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property float $price
 * @property string $deadline
 * @property string $created
 * @property int|null $city_id
 * @property int|null $executor_id
 * @property int|null $owner_id
 * @property int|null $status_id
 * @property int|null $category_id
 *
 * @property Feedback[] $feedbacks
 * @property Category $category
 * @property Users $executor
 * @property Users $owner
 * @property City $city
 * @property TaskStatus $status
 * @property TaskFile[] $taskFiles
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'address', 'latitude', 'longitude', 'price', 'deadline'], 'required'],
            [['description', 'latitude', 'longitude'], 'string'],
            [['price'], 'number'],
            [['deadline', 'created'], 'safe'],
            [['city_id', 'executor_id', 'owner_id', 'status_id', 'category_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'price' => 'Price',
            'deadline' => 'Deadline',
            'created' => 'Created',
            'city_id' => 'City ID',
            'executor_id' => 'Executor ID',
            'owner_id' => 'Owner ID',
            'status_id' => 'Status ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Users::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::className(), ['task_id' => 'id']);
    }

    // NOTE: my functions -----------------------------------------------------

    // TODO: disturb DRY!!!
    public function getPublishedTimeDiff(): string
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($this->created);
        $interval = $currentDate->diff($createDate);

        return ((int)$interval->d < 1)
            ? $interval->h . ' часа'
            : (int)$interval->d . ' дней и ' . $interval->h . ' часа';
    }
}
