<?php
declare(strict_types=1);

namespace app\modules\user\auth\actions;

use app\modules\common\props\Email;
use app\modules\common\props\Password;
use app\modules\common\props\PhoneNumber;
use app\modules\user\auth\IGateway;
use app\modules\user\props\Firstname;
use app\modules\user\props\Lastname;
use app\modules\user\props\Patronymic;
use app\modules\user\props\Roles;

final readonly class Register
{
    public function __construct(
        private IGateway $gateway
    )
    {
    }

    public function register(
        string $email,
        string $password,
        string $phoneNumber,
        string $firstname,
        string $lastname,
        string $patronymic,
        string $role
    ): void
    {
        $email = new Email($email);
        $password = new Password($password);
        $phoneNumber = new PhoneNumber($phoneNumber);
        $firstname = new Firstname($firstname);
        $lastname = new Lastname($lastname);
        $patronymic = new Patronymic($patronymic);
        $role = Roles::from($role);

        $this->gateway->register(
            $email,
            $password,
            $phoneNumber,
            $firstname,
            $lastname,
            $patronymic,
            $role
        );
    }
}