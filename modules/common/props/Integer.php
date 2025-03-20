<?php
declare(strict_types=1);

namespace app\modules\common\props;

class Integer
{
    public function __construct(private readonly int $value)
    {
    }

    public function value(): int {
        return $this->value;
    }
}
