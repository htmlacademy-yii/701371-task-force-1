<?php


namespace frontend\controllers;


use frontend\models\Notification;
use frontend\models\UsersAvatar;
use frontend\models\UsersImage;
use frontend\models\UserSpecialization;
use yii\helpers\ArrayHelper;
use DateTime;
use frontend\models\Category;
use frontend\models\City;
use frontend\models\Users;
use frontend\models\forms\SettingsForm;
use Yii;
use yii\web\UploadedFile;


/**
 * For working with user settings
 *
 * Class SettingsController
 */
class SettingsController extends SecuredController
{
    public $avatarsPath = '';
    public $photosPath = '';

    public function actionIndex(): string
    {
        $settingsForm = new SettingsForm;
        $settingsForm->populate(Yii::$app->user->identity->getId());

        $user = Users::findOne(Yii::$app->user->identity->getId());
        $cities = City::find()
            ->select('title')
            ->indexBy('id')
            ->column();

        $categoryList = Category::find()->all();
        $categoryMap = ArrayHelper::map($categoryList, 'id', 'name');

        $notificationList = SettingsForm::SUBSCRIPTION_MAP;
        $specializationList = UserSpecialization::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->all();

        // NOTE: save settings form
        if (Yii::$app->request->getIsPost()) {
            $settingsForm->load(Yii::$app->request->post());
            $files = UploadedFile::getInstances($settingsForm, 'files');
            $avatarUploadedFile = UploadedFile::getInstance($settingsForm, 'avatar');

            if ($settingsForm->validate() && $settingsForm->save()) {

                // NOTE: saving loading files of the current user
                foreach ($files as $file) {
                    $usersImage = new UsersImage();

                    // NOTE: saving files in folder
                    $fileName = $file->baseName . '.' . $file->extension;
                    $file->saveAs('files/' . $fileName);

                    // NOTE: saving file name for db
                    $usersImage->image_path = $fileName;
                    $usersImage->account_id = Yii::$app->user->identity->getId();
                    $usersImage->save();
                }

                // NOTE: saving avatar of the current user
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

        return $this->render('index', compact(
            'settingsForm',
            'cities',
            'categoryList',
            'categoryMap',
            'user',
            'notificationList',
            'specializationList'
        ));
    }

    public function actionDrop()
    {
        $id = Yii::$app->request->post('id');
        $userImage = UsersImage::find()
            ->where(['account_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['id' => $id])
            ->one();

        $userImage->delete();
    }
}
