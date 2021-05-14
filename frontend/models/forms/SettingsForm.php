<?php

namespace frontend\models\forms;

use app\models\UserNotification;
use DateTime;
use Exception;
use frontend\models\{Users, UsersAvatar, UsersContacts, UserSpecialization};
use Yii;
use yii\base\Model;
use yii\db\StaleObjectException;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * @var UserNotification $notificationModel
 * @var UserNotification $model
 */


/**
 * For working with model form of settings user
 *
 * Class SettingsForm
 */
class SettingsForm extends Model
{
    /**
     * @note
     * subscription_id
     */
    const SUBSCRIPTION_NEW_MESSAGE = 1;
    const SUBSCRIPTION_ACTION_TASK = 2;
    const SUBSCRIPTION_NEW_REVIEW = 3;
    const SUBSCRIPTION_SHOW_CONTACT_CUSTOMER = 4;

    const SUBSCRIPTION_MAP = [
        self::SUBSCRIPTION_NEW_MESSAGE => 'Новое значение',
        self::SUBSCRIPTION_ACTION_TASK => 'Действия по заданию',
        self::SUBSCRIPTION_NEW_REVIEW => 'Новый отзыв',
        self::SUBSCRIPTION_SHOW_CONTACT_CUSTOMER => 'Показывать мои контакты только заказчику',
    ];

    /**/

    /** @note for user name */
    public string $name;
    public string $oldName;

    /** @note for user eMail */
    public string $email;
    public string $oldEmail;

    /** @note for user city ID */
    public ?int $cityId;
    public ?int $oldCityId;

    /** @note for user birthday */
    public string $birthday;
    public string $oldBirthday;

    /** @note for user description */
    public ?string $description = '';
    public ?string $oldDescription = '';

    /** @note for user password */
    public string $password = '';
    public string $oldPassword = '';
    public string $passwordCopy = '';
    public string $oldPasswordCopy = '';

    /** @note for user uploading files */
    public array $files = [];

    /** @note for user contacts */
    public string $phone = '';
    public string $oldPhone = '';

    public string $skype;
    public string $oldSkype;

    public string $otherMessenger;
    public string $oldOtherMessenger;

    /** @note for user check boxes */
    public $specialization;
    public $oldSpecialization;

    public $notification;
    public $oldNotification;

    /** @note img with avatar */
    private $avatar;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email'], 'required'],
            [['cityId', 'phone'], 'integer'],
            [['avatar', 'specialization', 'birthday', 'files', 'notification'], 'safe'],
            [['password', 'passwordCopy'], 'string', 'min' => 6],
            [['passwordCopy'], 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => true],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 31],
            [['email', 'passwordCopy', 'skype', 'otherMessenger'], 'string', 'max' => 63],

            [['name', 'description', 'skype', 'phone', 'otherMessenger'],
                'filter', 'filter' => [Html::class, 'encode']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'avatar' => 'Сменить аватар',
            'name' => 'Ваше имя',
            'email' => 'eMail',
            'cityId' => 'Город',
            'birthday' => 'День рождения',
            'description' => 'Информация о себе',

            'specialization' => 'Специализация',
            'notification' => 'Уведомления',

            'password' => 'Новый паорль',
            'passwordCopy' => 'Повтор пароля',
            'files' => 'Фото работ',
            'phone' => 'Телефон',
            'skype' => 'skype',
            'otherMessenger' => 'Еще один мессенджер',
            'subscription_id' => 'Уведомления',
        ];
    }

    /**
     * @note
     * get current user avatar
     *
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @note
     * sets the user's avatar to the form model
     */
    public function setAvatar(): void
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');
    }

    /**
     * @note
     * for uploading files
     */
    public function uploadFiles(): void
    {
        /**
         * @note
         * get data from a field with no name:
         * 'name'=>'Image[image]'
         *
         * but, with name:
         * 'name'=>'image'
         */
        $this->files = UploadedFile::getInstancesByName('files');
    }

    /**
     * @note
     * save all user data
     *
     * @return bool
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function save(): bool
    {
        $user = Users::findOne(Yii::$app->user->identity->getId());

        $this->saveUserData($user);
        $this->saveUserSpecialization($user);
        $this->saveUserPassword($user);


        /**
         * @note
         * loading files look in the controllers -> SettingsController
         */

        $this->saveUserMessangers($user);
        $this->saveUserNotification($user);

        if (!$user->save(false)) {
            var_dump($user->getErrors());
            return false;
        }

        return true;
    }

    /**
     * @note
     * saving avatar of the current user
     *
     * @param $avatarUploadedFile
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function saveAvatar($avatarUploadedFile): void
    {
        if (!empty($this->avatar)) {
            $user = Users::findOne(Yii::$app->user->identity->getId());
            $avatarModel = new UsersAvatar();
            $currentAvatar = UsersAvatar::find()
                ->where(['account_id' => Yii::$app->user->identity->getId()])
                ->one();


            if (!empty($user->avatar)) {
                $currentAvatar->delete();
            }

            $fileName = $avatarUploadedFile->baseName . '.' . $avatarUploadedFile->extension;
            $avatarUploadedFile->saveAs('files/' . $fileName);

            $avatarModel->image_path = $fileName;
            $avatarModel->account_id = Yii::$app->user->identity->getId();
            $avatarModel->save();
        }
    }

    /**
     * @note
     * saving other data user
     *
     * @param $id
     * @throws Exception
     */
    public function populate($id): void
    {
        /** @var Users $user */
        $user = Users::findOne($id);

        /** @var UsersContacts $userContacts */
        $userContacts = UsersContacts::find()
            ->where(['account_id' => $id])
            ->one();

        $this->name = $this->oldName = $user->name;
        $this->email = $this->oldEmail = $user->email;

        /**
         * @note
         * drop down list - it determines which element will be selected, magic....
         */
        $this->cityId = $this->oldCityId = $user->city_id;

        $this->birthday = $this->oldBirthday = (new DateTime($user->born))->format('Y-m-d');
        $this->description = $this->oldDescription = $user->about;

        $this->specialization = $this->oldSpecialization = $user->specializationsList
            ? array_column($user->specializationsList, 'category_id')
            : [];

        $this->phone = $this->oldPhone = $userContacts->phone ?? '';
        $this->skype = $this->oldSkype = $userContacts->skype ?? '';
        $this->otherMessenger = $this->oldOtherMessenger = $userContacts->messanger ?? '';

        $this->notification = $this->oldNotification = $user->notificationsList ? array_column($user->notificationsList, 'notification_type') : [];
    }

    /**
     * @note
     * for saving basic block of user settings
     *
     * @param $user
     * @return void
     * @throws Exception
     */
    private function saveUserData($user): void
    {
        if ($this->name != $this->oldName) {
            $user->name = $this->name;
        }

        if ($this->email != $this->oldEmail) {
            $user->email = $this->email;
        }

        if ($this->cityId != $this->oldCityId) {
            $user->city_id = $this->cityId;
        }

        if ($this->birthday != $this->oldBirthday) {
            $user->born = (new DateTime($this->birthday))->format('Y-m-d');
        }

        if ($this->description != $this->oldDescription) {
            $user->about = $this->description;
        }

        $user->save();
    }

    /**
     * @note
     * saving user specialization
     *
     * @param $user
     * @throws \Throwable
     * @throws StaleObjectException
     */
    private function saveUserSpecialization($user): void
    {
        $specializationToAdd = array_diff($this->specialization ?: [], $this->oldSpecialization);
        $specializationToDrop = array_diff($this->oldSpecialization, $this->specialization ?: []);

        if ($specializationToAdd) {
            foreach ($specializationToAdd as $specializationId) {
                $specializationModel = new UserSpecialization();
                $specializationModel->user_id = $user->id;
                $specializationModel->category_id = $specializationId;
                $specializationModel->save();
            }
        }

        if ($specializationToDrop) {
            foreach ($specializationToDrop as $specializationId) {
                $model = UserSpecialization::find()
                    ->where(['category_id' => $specializationId, 'user_id' => $user->id])
                    ->one();

                if (!$model) {
                    /**
                     * @note
                     * everything below is skipped and goes to the next iteration
                     */
                    continue;
                }

                $model->delete();
            }
        }
    }

    /**
     * @note
     * save user password
     *
     * @param $user
     */
    private function saveUserPassword($user): void
    {
        if (!$this->password || !$this->passwordCopy) {
            return;
        }

        die('ok');

        $user->password = $this->password;
        $user->save();
    }

    /**
     * @note
     * saving user phone, skype and messanger
     *
     * @param Users $user
     * @return bool
     */
    private function saveUserMessangers(Users $user): bool
    {
        $userContacts = UsersContacts::find()
            ->where(['account_id' => $user->id])
            ->one();

        if (!$userContacts) {
            $userContacts = new UsersContacts();
        }

        if ($this->phone != $this->oldPhone || $this->phone != '') {
            $userContacts->phone = $this->phone;
        }

        if ($this->skype != $this->oldSkype) {
            $userContacts->skype = $this->skype;
        }

        if ($this->otherMessenger != $this->oldOtherMessenger) {
            $userContacts->messanger = $this->otherMessenger;
        }

        $userContacts->account_id = $user->id;

        return $userContacts->save();
    }

    /**
     * @note
     * saving user notification
     *
     * @param $user
     */
    private function saveUserNotification($user): void
    {
        $notificationToAdd  = array_diff($this->notification ?: [], $this->oldNotification);
        $notificationToDrop = array_diff($this->oldNotification, $this->notification ?: []);

        if ($notificationToAdd) {
            foreach ($notificationToAdd as $notificationId) {
                /** @var UserNotification $notificationModel */
                $notificationModel = UserNotification::find()
                    ->where(['user_id' => $user->id])
                    ->andWhere(['notification_type' => $notificationId])
                    ->one();

                if (!$notificationModel) {
                    $notificationModel = new UserNotification();
                    $notificationModel->user_id = $user->id;
                    $notificationModel->notification_type = $notificationId;
                }

                $notificationModel->active = 1;
                $notificationModel->save();
            }
        }

        if ($notificationToDrop) {
            foreach ($notificationToDrop as $notificationId) {
                /** @var UserNotification $model */
                $model = UserNotification::find()
                    ->where(['notification_type' => $notificationId, 'user_id' => $user->id])
                    ->one();

                if (!$model) {
                    /**
                     * @note
                     * everything below is skipped and goes to the next iteration
                     */
                    continue;
                }

                $model->active = 0;
                $model->save();
            }
        }
    }
}
