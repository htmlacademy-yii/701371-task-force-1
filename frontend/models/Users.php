<?php

namespace frontend\models;

use app\models\UserNotification;
use Yii;
use yii\db\{ActiveRecord, ActiveQuery};
use yii\web\IdentityInterface;
use yii\base\{InvalidConfigException, Exception};


/**
 * @note
 * this is the model class for table "signup".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $address
 * @property string $born
 * @property string $about
 * @property string $visit
 * @property int $quest_completed
 * @property int $views_counter
 * @property int $hide_account
 * @property int|null $city_id
 * @property float $averageRating
 *
 * @property City $city
 * @property Feedback[] $feedbacks
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Reviews[] $reviews
 * @property Task[] $tasks
 * @property Task[] $executedTasks
 * @property TaskRespond[] $responds
 * @property UsersContacts $contacts
 * @property UsersAvatar $avatar
 * @property UsersRoles $role
 * @property UserSpecialization[] $specializationsList
 * @property UserNotification[] $notificationsList
 * @property UsersCategory[] $usersCategories
 * @property UsersImage[] $usersImages
 * @property UsersFavorites[] $usersFavorites
 * @property UsersFavorites[] $usersFavorites0
 * @property UsersRoles $roles
 */
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email', 'name', 'password'], 'required'],
            [['address', 'about'], 'string'],
            [['born', 'visit'], 'safe'],
            [['quest_completed',
                'views_counter',
                'hide_account',
                'city_id',
                ], 'integer'
            ],
            [['email', 'name', 'password'], 'string', 'max' => 64],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::class,
                'targetAttribute' => ['city_id' => 'id']
            ],
            [['email'], 'unique'],
            [['auth_key', 'password_reset_token', 'status'], 'safe'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'address' => 'Address',
            'born' => 'Born',
            'about' => 'About',
            'visit' => 'Visit',
            'quest_completed' => 'Quest Completed',
            'views_counter' => 'Views Counter',
            'hide_account' => 'Hide Account',
            'city_id' => 'City ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(Message::class, ['sender_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages0(): ActiveQuery
    {
        return $this->hasMany(Message::class, ['reciever_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Reviews::class, ['task_id' => 'id'])
            ->viaTable(Task::tableName(), ['executor_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::class, ['owner_id' => 'id']);
    }

    public function getExecutedTasks(): ActiveQuery
    {
        return $this->hasMany(Task::class, ['executor_id' => 'id']);
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
    public function getContacts(): ActiveQuery
    {
        return $this->hasOne(UsersContacts::class,
            ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAvatar(): ActiveQuery
    {
        return $this->hasOne(UsersAvatar::class, ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecializationsList(): ActiveQuery
    {
        return $this->hasMany(UserSpecialization::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNotificationsList(): ActiveQuery
    {
        return $this->hasMany(UserNotification::class, ['user_id' => 'id'])->where(['active' => 1]);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersCategories(): ActiveQuery
    {
        return $this->hasMany(UsersCategory::class,
            ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersImages(): ActiveQuery
    {
        return $this->hasMany(UsersImage::class,
            ['account_id' => 'id']);
    }


    /** @note my functions ------------------------------------------------- */

    /**
     * @return ActiveQuery
     */
    public function getResponds(): ActiveQuery
    {
        return $this->hasMany(TaskRespond::class, ['user_id' => 'id']);
    }

    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string|null
     */
    public function getAuthKey(): ?string
    {
        return null;
    }

    /**
     * @note
     * for rating
     *
     * @return float
     */
    public function getAverageRating(): float
    {
        /**
         * @note
         * if there are no reviews in the current
         * model (the array is empty), then...
         */
        if (!$this->reviews) {
            return 0;
        }

        /**
         * @note
         * generates an array of array values based on the key that I passed,
         * i.e. it will eventually return an array consisting of the rating
         * value for each record
         */
        return array_sum(array_column($this->reviews, 'rating')) / count($this->reviews);
    }

    /**
     * @note
     * used in - views/layouts/main.php
     *
     * @return string
     */
    public function getUserAvatarPath(): string
    {
        return $this->avatar ? $this->avatar->image_path : 'user-photo.png';
    }

    /**
     * @param int|string $id
     * @return Users|IdentityInterface|null
     */
    public static function findIdentity($id): ?Users
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey): ?bool
    {
        return null;
    }

    /**
     * @param string string $username
     * @return Users|null
     */
    public static function findByUsername(string $username): ?Users
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * @param string string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @note
     * for roles
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        /**
         * @note
         * true || false
         */
        return count($this->specializationsList) === 0;
    }

    /**
     * @note
     * generates "remember me" authentication key
     *
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @note
     * removes password reset token
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    /**
     * @note
     * generates new password reset token
     *
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
