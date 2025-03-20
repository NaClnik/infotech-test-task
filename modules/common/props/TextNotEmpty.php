<?php
declare(strict_types=1);

namespace app\modules\common\props;

use InvalidArgumentException;

class TextNotEmpty extends Text
{
    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidArgumentException('Текст не должен быть пустым');
        }

        parent::__construct($value);
    }
}
