<?php

namespace frontend\models;

use app\models\UserNotification;

use Yii;
use yii\db\{ActiveRecord, ActiveQuery};
use yii\web\IdentityInterface;


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
 * @property int $show_contacts_to_customer
 * @property int|null $role_id
 * @property int|null $specialization_id
 * @property int|null $raiting_id
 * @property int|null $city_id
 * @property int|null $contacts_id
 * @property int|null $notification_id
 *
 * @property Feedback[] $feedbacks
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Reviews[] $reviews
 * @property Task[] $tasks
 * @property City $city
 * @property UsersContacts $contacts
 * @property UsersAvatar $avatar
 * @property UsersRoles $role
 * @property UserSpecialization[] $specializationsList
 * @property UserNotification[] $notificationsList
 * @property UsersCategory[] $usersCategories
 * @property UsersFavorites[] $usersFavorites
 * @property UsersFavorites[] $usersFavorites0
 * @property UsersImage[] $usersImages
 * @property Task[] $executedTasks
 * @property int $completedTasksCount
 *
 * @property UserRoles $roles
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const ROLE_CLIENT = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
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
                'show_contacts_to_customer',
                'role_id',
                'specialization_id',
                'raiting_id',
                'city_id',
                'contacts_id',
                'notification_id'], 'integer'
            ],
            [['email', 'name', 'password'], 'string', 'max' => 64],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['city_id' => 'id']
            ],
            [['contacts_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => UsersContacts::className(),
                'targetAttribute' => ['contacts_id' => 'id']
            ],
            [['role_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => UsersRoles::className(),
                'targetAttribute' => ['role_id' => 'id']
            ],
            [['specialization_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => UserSpecialization::className(),
                'targetAttribute' => ['specialization_id' => 'id']
            ],
            [['notification_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Notification::className(),
                'targetAttribute' => ['notification_id' => 'id']
            ],
            [['email'], 'unique'],
            [['auth_key', 'password_reset_token', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
            'show_contacts_to_customer' => 'Show Contacts To Customer',
            'role_id' => 'Role ID',
            'specialization_id' => 'specialization ID',
            'raiting_id' => 'Raiting ID',
            'city_id' => 'City ID',
            'contacts_id' => 'Contacts ID',
            'notification_id' => 'Notification ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFeedbacks(): ActiveQuery
    {
        return $this->hasMany(Feedback::className(), ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages0(): ActiveQuery
    {
        return $this->hasMany(Message::className(), ['reciever_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Reviews::className(), ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::className(), ['owner_id' => 'id']);
    }

    public function getExecutedTasks(): ActiveQuery
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
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
    public function getContacts(): ActiveQuery
    {
        return $this->hasOne(UsersContacts::className(),
            ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAvatar(): ActiveQuery
    {
        return $this->hasOne(UsersAvatar::className(), ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRole(): ActiveQuery
    {
        return $this->hasOne(UsersRoles::className(), ['id' => 'role_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecializationsList(): ActiveQuery
    {
        return $this->hasMany(UserSpecialization::className(), ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNotificationsList(): ActiveQuery
    {
        return $this->hasMany(UserNotification::className(), ['user_id' => 'id'])->where(['active' => 1]);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersCategories(): ActiveQuery
    {
        return $this->hasMany(UsersCategory::className(),
            ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersFavorites(): ActiveQuery
    {
        return $this->hasMany(UsersFavorites::className(),
            ['favorites_account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersFavorites0(): ActiveQuery
    {
        return $this->hasMany(UsersFavorites::className(),
            ['account_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersImages(): ActiveQuery
    {
        return $this->hasMany(UsersImage::className(),
            ['account_id' => 'id']);
    }


    /** @note my functions ------------------------------------------------- */

    /**
     * @note
     * for login
     *
     * @return ActiveQuery
     */
    public function getRespond(): ActiveQuery
    {
        return $this->hasMany(TaskRespond::className(), ['task_id' => 'id']);
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
        return array_sum(array_column($this->reviews, 'raiting')) / count($this->reviews);
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
     * @param $username
     * @return Users|null
     */
    public static function findByUsername(string $username): ?Users
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * @param $password
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
     * for all bottom methods
     * for vk auth, import methods from user.php model
     */

    /**
     * @note
     * generates "remember me" authentication key
     *
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @note
     * generates new password reset token
     *
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
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
}
