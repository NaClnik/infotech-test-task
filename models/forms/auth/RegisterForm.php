<?php
declare(strict_types=1);

namespace app\models\forms\auth;

use app\utils\ApplicationUtils;
use Override;
use yii\base\Model;

final class RegisterForm extends Model
{
    public string $email = '';
    public string $password = '';
    public string $phoneNumber = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $patronymic = '';
    public string $role = '';
    public string $verifyCode = '';

    #[Override]
    public function rules(): array
    {
        return [
            [['email', 'password', 'phoneNumber', 'firstname', 'lastname', 'patronymic', 'role'], 'required'],
            [['email', 'password', 'phoneNumber', 'firstname', 'lastname', 'patronymic', 'role'], 'string'],
            ['email', 'email'],
            ['phoneNumber', 'match', 'pattern' => ApplicationUtils::PHONE_REGEX_PATTERN],
            ['verifyCode', 'captcha'],
        ];
    }
}