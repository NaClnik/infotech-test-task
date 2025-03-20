<?php
declare(strict_types=1);

namespace app\modules\common\props;

use app\utils\ApplicationUtils;
use InvalidArgumentException;

final class PhoneNumber extends TextNotEmpty
{
    public function __construct(string $value)
    {
        $value = trim($value);

        if (preg_match(ApplicationUtils::PHONE_REGEX_PATTERN, $value) !== 1) {
            throw new InvalidArgumentException("Переданное значение \"$value\" не соответствует формату номера телефона");
        }

        parent::__construct($value);
    }

}