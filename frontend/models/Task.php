<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


/**
 * @note
 * this is the model class for table "task".
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
 * @property TaskRespond[] $responds
 * @property TaskRespond[] $userRespond
 */
class Task extends ActiveRecord
{
    const STATUS_RESPOND = 1;
    const STATUS_CANCEL = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_FAIL = 4;
    const STATUS_WORK = 5;
    const STATUS_NEW = 6;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'task';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'description', 'address', 'latitude', 'longitude', 'price', 'deadline'], 'required'],
            [['description'], 'string'],
            [['price', 'latitude', 'longitude'], 'number'],
            [['deadline', 'created'], 'safe'],
            [['city_id', 'executor_id', 'owner_id', 'status_id', 'category_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['executor_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::class, 'targetAttribute' => ['status_id' => 'id']],
            [['avatar_id'], 'safe'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getFeedbacks(): ActiveQuery
    {
        return $this->hasMany(Feedback::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'executor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOwner(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'owner_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(TaskStatus::class, ['id' => 'status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTaskFiles(): ActiveQuery
    {
        return $this->hasMany(TaskFile::class, ['task_id' => 'id']);
    }


    /** @note my functions ------------------------------------------------- */

    /**
     * @return ActiveQuery
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasOne(Reviews::class, ['status_id' => 'city_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getResponds(): ActiveQuery
    {
        return $this->hasMany(TaskRespond::class, ['task_id' => 'id']);
    }

    /**/

    /**
     * @return bool
     */
    public function isResponded(): bool
    {
        return $this->status_id == self::STATUS_RESPOND;
    }

    /**
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->status_id == self::STATUS_CANCEL;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status_id == self::STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status_id == self::STATUS_FAIL;
    }

    /**
     * @return bool
     */
    public function isWork(): bool
    {
        return $this->status_id == self::STATUS_WORK;
    }

    public function isNew(): bool
    {
        return $this->status_id == self::STATUS_NEW;
    }

    /**
     * @note
     * used in - views/tasks/view.php
     * for output avatar of owner
     *
     * @return string
     */
    public function getOwnerAvatarPath(): string
    {
        $avatar = UsersAvatar::findOne($this->owner_id);

        return $avatar ? $avatar->image_path : 'user-photo.png';
    }
}
