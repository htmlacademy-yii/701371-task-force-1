<?php


namespace TaskForce\components;


use app\models\Auth;
use frontend\models\Users;
use Yii;
use yii\authclient\OAuth2;
use yii\web\NotFoundHttpException;


class AuthVKontakte
{
    /**
     * @note
     * for VK auth
     *
     * @param OAuth2 $client
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public static function onAuthSuccess(OAuth2 $client)
    {
        $attributes = $client->getUserAttributes();

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            $user = $auth ? $auth->user : self::registryNewUser($client, $attributes);

            if ($user) {
                Yii::$app->user->login($user);
            } else {
                throw new NotFoundHttpException('Пользователь не найден');
            }
        } else {
            /**
             * @note
             * if the user is NOT a guest, and if he is already logged in
             * then we add an external authentication service in table Auth
             */
            if (!$auth) {
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

    private static function registryNewUser($client, $attributes)
    {
        if (isset($attributes['email']) && Users::find()->where(['email' => $attributes['email']])->exists()) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', "Пользователь с такой электронной почтой как в {client} уже 
                    существует, но с ним не связан. Для начала войдите на сайт использую электронную 
                    почту, для того, что бы связать её.", ['client' => $client->getTitle()]),
            ]);
        } else {
            $user = new Users([
                'name' => $attributes['first_name'] . ' ' . $attributes['last_name'],
                'email' => $attributes['email'],
                'password' => Yii::$app->security->generateRandomString(6),
            ]);
            
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            $transaction = $user->getDb()->beginTransaction();

            if ($user->save()) {
                $auth = new Auth([
                    'user_id' => $user->id,
                    'source' => $client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);

                if ($auth->save()) {
                    $transaction->commit();

                    return $user;
                }
            }

            $transaction->rollBack();
        }

        return null;
    }
}
