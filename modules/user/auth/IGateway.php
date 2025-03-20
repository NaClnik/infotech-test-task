<?php
declare(strict_types=1);

namespace app\modules\user\auth;

use app\modules\common\props\Email;
use app\modules\common\props\Password;
use app\modules\common\props\PhoneNumber;
use app\modules\user\props\Firstname;
use app\modules\user\props\Lastname;
use app\modules\user\props\Patronymic;
use app\modules\user\props\Roles;

interface IGateway
{
    public function register(
        Email $userEmail,
        Password $userPassword,
        PhoneNumber $userPhoneNumber,
        Firstname $userFirstname,
        Lastname $userLastname,
        Patronymic $userPatronymic,
        Roles $role
    ): void;
}