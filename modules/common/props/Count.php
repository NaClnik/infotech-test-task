<?php
declare(strict_types=1);

namespace app\modules\common\props;

use InvalidArgumentException;

final class Count extends Integer
{
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException("Количество не может быть меньше нуля. Переданное значение: \"$value\"");
        }

        parent::__construct($value);
    }
}