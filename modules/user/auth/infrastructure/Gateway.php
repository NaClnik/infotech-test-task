<?php
declare(strict_types=1);

namespace app\modules\user\auth\infrastructure;

use app\modules\common\props\Email;
use app\modules\common\props\Password;
use app\modules\common\props\PhoneNumber;
use app\modules\user\auth\IGateway;
use app\modules\user\props\Firstname;
use app\modules\user\props\Lastname;
use app\modules\user\props\Patronymic;
use app\modules\user\props\Roles;
use Yii;
use yii\base\Exception;

final class Gateway implements IGateway
{

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function register(
        Email $userEmail,
        Password $userPassword,
        PhoneNumber $userPhoneNumber,
        Firstname $userFirstname,
        Lastname $userLastname,
        Patronymic $userPatronymic,
        Roles $role
    ): void
    {
        $authManager = Yii::$app->getAuthManager();
        $securityService = Yii::$app->getSecurity();

        Yii::$app->getDb()->createCommand()->insert('{{%users}}', [
            'user_email' => $userEmail->value(),
            'user_phone_number' => $userPhoneNumber->value(),
            'user_firstname' => $userFirstname->value(),
            'user_lastname' => $userLastname->value(),
            'user_patronymic' => $userPatronymic->value(),
            'user_password_hash' => $securityService->generatePasswordHash($userPassword->value()),
            'user_auth_key' => $securityService->generateRandomString(),
        ])->execute();

        $insertedUserId = Yii::$app->getDb()->getLastInsertID();

        $role = $authManager->getRole($role->value);
        $authManager->assign($role, $insertedUserId);
    }
}