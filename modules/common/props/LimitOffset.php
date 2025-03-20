<?php
declare(strict_types=1);

namespace app\modules\common\props;

use InvalidArgumentException;

final readonly class LimitOffset
{
    public function __construct(private int $limit, private int $offset) {
        if ($limit < 0) {
            throw new InvalidArgumentException("Limit не может быть меньше нуля. Переданное значение: $limit");
        }

        if ($offset < 0) {
            throw new InvalidArgumentException("Offset не может быть меньше нуля. Переданное значение: $offset");
        }
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }
}