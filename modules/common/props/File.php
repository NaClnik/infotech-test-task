<?php
declare(strict_types=1);

namespace app\modules\common\props;

final readonly class File
{
    public function __construct(
        private string $name
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }
}