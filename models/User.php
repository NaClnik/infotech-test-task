<?php

namespace app\models;

use Override;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $user_id
 * @property string $user_email
 * @property string $user_firstname
 * @property string $user_lastname
 * @property string $user_patronymic
 * @property string $user_password_hash
 * @property string $user_auth_key
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    #[Override]
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public static function findIdentity($id): ?self
    {
        /** @var User $user */
        $user = self::find()->where(['user_id' => $id])->one();

        return $user;
    }

    /**
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): void
    {
        throw new NotSupportedException("REST API не поддерживается");
    }

    public static function findByUsername($username): ?self
    {
        /** @var User $user */
        $user = self::find()->where(['user_email' => $username])->one();

        return $user;
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function getAuthKey(): string
    {
        return $this->user_auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->user_auth_key === $authKey;
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->user_password_hash);
    }
}
