<?php
declare(strict_types=1);

namespace app\modules\common\props;

use InvalidArgumentException;

class Id extends Integer
{
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Id не может быть меньше или равно 0');
        }

        parent::__construct($value);
    }
}
