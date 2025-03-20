<?php
declare(strict_types=1);

namespace app\modules\user\props;

enum Roles : string
{
    case Reader = "reader";
    case Author = "author";
}
