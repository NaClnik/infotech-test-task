<?php
declare(strict_types=1);

namespace app\modules\system\notifications\listeners;

use app\modules\book\events\BookHasBeenAdded;
use app\modules\book\props\BookName;
use app\modules\common\props\BookId;
use app\modules\common\props\UserId;
use app\modules\system\notifications\IGateway;

final readonly class SendSmsAboutNewBookForSubscribers
{
    public function __construct(
        private IGateway $gateway
    )
    {
    }

    public function handle(BookHasBeenAdded $event): void
    {
        $authorId = new UserId($event->authorId);
        $bookId = new BookId($event->bookId);
        $bookName = new BookName($event->bookName);

        $this->gateway->sendSmsAboutNewBookForSubscribers($authorId, $bookId, $bookName);
    }
}