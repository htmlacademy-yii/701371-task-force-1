<?php

namespace frontend\models\forms;

use app\models\UserNotification;
use DateTime;
use frontend\models\Users;
use frontend\models\UsersAvatar;
use frontend\models\UserSpecialization;
use Yii;
use yii\base\Model;
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

    /** @note img with avatar */
    private $avatar;

    /** @note for user name */
    public $name;
    public $oldName;

    /** @note for user eMail */
    public $email;
    public $oldEmail;

    /** @note for user city ID */
    public $cityId;
    public $oldCityId;

    /** @note for user birthday */
    public $birthday;
    public $oldBirthday;

    /** @note for user description */
    public $description;
    public $oldDescription;

    /** @note for user password */
    public $password;
    public $oldPassword;
    public $passwordCopy;
    public $oldPasswordCopy;

    /** @note for user uploading files */
    public $files;
    public $oldFiles;

    /** @note for user contacts */
    public $phone;
    public $oldPhone;

    public $skype;
    public $oldSkype;

    public $otherMessenger;
    public $oldOtherMessenger;

    /** @note for user check boxes */
    public $specialization;
    public $oldSpecialization;

    public $notification;
    public $oldNotification;

    /**/

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_setting';
    }

    /**/

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

    /**/

    public function getAvatar(): ?UploadedFile
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

    /**/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['cityId', 'phone'], 'integer'],
            [['avatar', 'specialization', 'birthday', 'files', 'notification'], 'safe'],
            [['password', 'passwordCopy'], 'string', 'min' => 6],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 31],
            [['email', 'passwordCopy', 'skype', 'otherMessenger'], 'string', 'max' => 63],
        ];
    }

    /**/

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

    /**/

    /**
     * @note
     * saving user data
     *
     * @var Users $user
     * @throws \Exception
     */
    private function saveUserData($user)
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
     * @throws \yii\db\StaleObjectException
     */
    private function saveUserSpecialization($user)
    {
        $specializationToAdd = array_diff($this->specialization, $this->oldSpecialization);
        $specializationToDrop = array_diff($this->oldSpecialization, $this->specialization);

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
    private function saveUserPassword($user)
    {
        if (($this->password && $this->oldPassword
            && $this->passwordCopy && $this->oldPasswordCopy) !== $user->password)
        {
            $user->password = $this->password;
        }
    }

    /**
     * @note
     * saving user phone, skype and messanger
     *
     * @param $user
     */
    private function saveUserMessangers(Users $user)
    {
        $contacts = $user->contacts;
        if ($this->phone != $this->oldPhone) {
            $contacts->phone = $this->phone;
        }

        if ($this->skype != $this->oldSkype) {
            $contacts->skype = $this->skype;
        }

        if ($this->otherMessenger != $this->oldOtherMessenger) {
            $contacts->messanger = $this->otherMessenger;
        }

        $contacts->save();
    }

    /**
     * @note
     * saving user notification
     *
     * @param $user
     */
    private function saveUserNotification($user) {
        $notificationToAdd  = array_diff($this->notification, $this->oldNotification);
        $notificationToDrop = array_diff($this->oldNotification, $this->notification);

        if ($notificationToAdd) {
            foreach ($notificationToAdd as $notificationId) {
                $notificationModel = UserNotification::find()
                    ->where(['user_id' => $user->id])
                    ->andWhere(['notification_type' => $notificationId])
                    ->one();

                if (!$notificationModel) {
                    $notificationModel = new UserNotification();
                    $notificationModel->user_id = $user->id;
                    $notificationModel->notification_type = $notificationId;
                    $notificationModel->active = 1;
                    $notificationModel->save();

                    var_dump($notificationModel->getErrors());
                } else {
                    $notificationModel->active = 1;
                    $notificationModel->save();
                    var_dump($notificationModel->getErrors());
                }
            }
        }

        if ($notificationToDrop) {
            foreach ($notificationToDrop as $notificationId) {
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

    /**
     * @note
     * save all user data
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save()
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

    /**/

    /**
     * @note
     * saving avatar of the current user
     *
     * @param $avatarUploadedFile
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function saveAvatar($avatarUploadedFile)
    {
        if (!empty($this->avatar)) {
            $currentAvatar = UsersAvatar::find()
                ->where(['account_id' => Yii::$app->user->identity->getId()])
                ->one();
            $currentAvatar->delete();

            $avatarModel = new UsersAvatar();
            $fileName = $avatarUploadedFile->baseName . '.' . $avatarUploadedFile->extension;
            $avatarUploadedFile->saveAs('files/' . $fileName);

            $avatarModel->image_path = $fileName;
            $avatarModel->account_id = Yii::$app->user->identity->getId();
            $avatarModel->save();
        }
    }

    /**/

    public function populate($id)
    {
        $user = Users::findOne($id);

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

        $this->phone = $this->oldPhone = Html::encode($user->contacts->phone ?? '');
        $this->skype = $this->oldSkype = Html::encode($user->contacts->skype ?? '');
        $this->otherMessenger = $this->oldOtherMessenger = Html::encode(Yii::$app->user->identity->contacts->messanger ?? '');

        $this->notification = $this->oldNotification = $user->notificationsList ? array_column($user->notificationsList, 'notification_type') : [];
    }
}
