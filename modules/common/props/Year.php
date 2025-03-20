<?php
declare(strict_types=1);

namespace app\modules\common\props;

use InvalidArgumentException;

final class Year extends Integer
{
    public function __construct(int $value)
    {
        // Делаю проверку на ноль, т.к. в григорианском календаре нет нулевого года.
        // Проверку на отрицательность года не делаю, т.к. год может быть до н.э.
        // Хоть это и не применимо к данному тестовому заданию, я считаю, что так будет правильно.
        if ($value === 0) {
            throw new InvalidArgumentException('Год не может быть равен нулю');
        }

        $currentYear = (int)date('Y');

        if ($value > $currentYear) {
            throw new InvalidArgumentException("Год не может быть больше текущего. Текущий год: \"$currentYear\". Переданное значение: \"$value\"");
        }

        parent::__construct($value);
    }
}