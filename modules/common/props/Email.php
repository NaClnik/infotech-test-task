<?php
declare(strict_types=1);

namespace app\modules\common\props;

use InvalidArgumentException;

final class Email extends TextNotEmpty
{
    public function __construct(string $value)
    {
        $value = trim($value);

        $emailValidationRegexPattern = '/^\\S+@\\S+\\.\\S+$/';
        if (preg_match($emailValidationRegexPattern, $value) !== 1) {
            throw new InvalidArgumentException("Переданное значение \"$value\" не соответствует формату email");
        }

        parent::__construct($value);
    }
}