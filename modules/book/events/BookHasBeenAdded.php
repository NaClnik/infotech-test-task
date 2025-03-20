<?php
declare(strict_types=1);

namespace app\modules\book\events;

use yii\base\Event;

final class BookHasBeenAdded extends Event
{
    public const string EVENT_NAME = 'EVENT_BOOK_HAS_BEEN_ADDED';

    public function __construct(
        public int $authorId,
        public int $bookId,
        public string $bookName
    )
    {
        parent::__construct();
    }
}