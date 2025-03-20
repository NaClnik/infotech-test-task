<?php
declare(strict_types=1);

namespace app\modules\common\props;

class Text
{
    public function __construct(private string $value)
    {
        $this->value = trim($value);
    }

    public function value(): string {
        return $this->value;
    }
}
