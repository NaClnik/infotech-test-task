<?php
declare(strict_types=1);

namespace app\modules\system\notifications;

use app\modules\book\props\BookName;
use app\modules\common\props\BookId;
use app\modules\common\props\UserId;

interface IGateway
{
    public function sendSmsAboutNewBookForSubscribers(UserId $authorId, BookId $bookId, BookName $bookName): void;
}