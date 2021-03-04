<?php

namespace frontend\models;

use app\models\UserNotification;
use Yii;
use yii\db\{ActiveRecord, ActiveQuery};
use yii\web\IdentityInterface;


/**
 * This is the model class for table "signup".
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
            ['id' => 'contacts_id']);
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

    public function getAverageRating(): float
    {
        // NOTE: если в текущей модели нету ни одного отзыва (массив пуст), то...
        if (!$this->reviews) {
            return 0;
        }

        /*
         * NOTE:
         * array_column - формирует массив значений массива по колючу, который
         * я передал, т.е. в итоге вернет массив состоящий из значения рейтинга
         * для каждой записи
         * */
        return array_sum(array_column($this->reviews, 'raiting')) / count($this->reviews);
    }

    /**/

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

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**/

    /**
     * @note
     * for roles
     *
     * @return bool
     */
    public function isCustomer()
    {
        /**
         * @note
         * if there are no roles
         */
        if (!$this->role) {
            return false;
        }

        /**
         * @note
         * true || false
         */
        return $this->role->key_code === UsersRoles::CUSTOMER_KEY_CODE;
    }

    /**/

    /**
     * @note
     * for all bottom methods
     * for vk auth, import methods from user.php model
     */

    /**
     * @note
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @note
     * Generates new password reset token
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
    public function getUserAvatarPath()
    {
        return $this->avatar ? $this->avatar->image_path : 'user-photo.png';
    }

    /**
     * @return int|string
     */
    public function getCompletedTasksCount()
    {
        return $this->getExecutedTasks()
            ->where(['status_id' => Task::STATUS_COMPLETED])
            ->count();
    }
}
