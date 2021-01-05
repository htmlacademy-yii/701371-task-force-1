<?php


namespace frontend\models\forms;


use app\models\UserNotification;
use common\models\User;
use DateTime;
use frontend\models\Users;
use frontend\models\UsersImage;
use frontend\models\UserSpecialization;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
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
    // NOTE: subscription_id
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

    // **

    // NOTE: img with avatar
    private $avatar;

    // NOTE: user name
    public $name;
    public $oldName;

    // NOTE: user email
    public $email;
    public $oldEmail;

    // NOTE: user city id
    public $cityId;
    public $oldCityId;

    // NOTE: user birthday
    public $birthday;
    public $oldBirthday;

    // NOTE: user desc
    public $description;
    public $oldDescription;

    // **

    // NOTE: user password
    public $password;
    public $oldPassword;
    public $passwordCopy;
    public $oldPasswordCopy;

    // NOTE: user files
    public $files;
    public $oldFiles;

    // **

    // NOTE: user phone
    public $phone;
    public $oldPhone;

    // NOTE: user skype
    public $skype;
    public $oldSkype;

    // NOTE: other user messangers
    public $otherMessenger;
    public $oldOtherMessenger;

    public $specialization;
    public $oldSpecialization;

    public $notification;
    public $oldNotification;

    // **

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_setting';
    }

    // TODO: сделать у пользователя в моделе
    /*
    public function getFiles(): ?array
    {
        return $this->files;
    }
    */

    public function uploadFiles(): void
    {
        /**
         * NOTE:
         * get data from a field with no name:
         * 'name'=>'Image[image]'
         *
         * but, with name:
         * 'name'=>'image'
         */
        $this->files = UploadedFile::getInstancesByName('files');
    }


    public function getAvatar(): ?UploadedFile
    {
        return $this->avatar;
    }

    // NOTE: Sets the user's avatar to the form model
    public function setAvatar(): void
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['cityId', 'phone'], 'integer'],
            [['birthday', 'files', 'notification'], 'safe'],
            [['password', 'passwordCopy'], 'string', 'min' => 6],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 31],
            [['email', 'passwordCopy', 'skype', 'otherMessenger'], 'string', 'max' => 63],
        ];
    }

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

    public function save()
    {
        $user = Users::findOne(Yii::$app->user->identity->getId());

        /**/

        // NOTE: loading avatar look in the controllers -> SettingsController

        /**/

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

        /**/

        $specializationToAdd  = array_diff($this->specialization, $this->oldSpecialization);
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
                    continue; // все что ниже пропускается и переходит к сл/ итерации
                }

                $model->delete();
            }
        }

        /**/

        if (($this->password && $this->oldPassword
            && $this->passwordCopy && $this->oldPasswordCopy) !== $user->password)
        {
            $user->password = $this->password;
        }

        /**/

        // NOTE: loading files look in the controllers -> SettingsController

        /**/

        if ($this->phone != $this->oldPhone) {
            $user->contacts->phone = $this->phone;
        }

        if ($this->skype != $this->oldSkype) {
            $user->contacts->skype = $this->skype;
        }

        if ($this->otherMessenger != $this->oldOtherMessenger) {
            $user->contacts->messanger = $this->otherMessenger;
        }

        /**/

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
                    // NOTE: everything below is skipped and goes to the next iteration
                    continue;
                }

                $model->active = 0;
                $model->save();
            }
        }

        /**/

        if (!$user->save(false)) {
            var_dump($user->getErrors());
            return false;
        }

        return true;
    }

    public function populate($id)
    {
        $user = Users::findOne($id);

        $this->name = $this->oldName = $user->name;
        $this->email = $this->oldEmail = $user->email;

        // NOTE: dropdownlist - it determines which element will be selected, magic....
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