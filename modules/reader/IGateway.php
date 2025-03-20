<?php
declare(strict_types=1);


namespace app\modules\reader;

use app\modules\common\props\UserId;

interface IGateway
{
    public function subscribe(UserId $subscriberId, UserId $authorId): void;
}