<?php
declare(strict_types=1);

namespace app\modules\book\actions;

use app\modules\book\events\BookHasBeenAdded;
use app\modules\book\IGateway;
use app\modules\book\props\BookDescription;
use app\modules\book\props\BookIsbn;
use app\modules\book\props\BookName;
use app\modules\common\props\File;
use app\modules\common\props\UserId;
use DateTimeImmutable;
use yii\base\Component;

final class Add extends Component
{
    public function __construct(
        private readonly IGateway $gateway
    )
    {
        parent::__construct();
    }

    public function add(
        int $authorId,
        string $bookName,
        string $bookDescription,
        DateTimeImmutable $bookReleaseDate,
        string $bookIsbn,
        ?string $bookPhotoFilename
    ): void
    {
        $authorId = new UserId($authorId);
        $bookName = new BookName($bookName);
        $bookDescription = new BookDescription($bookDescription);
        $bookIsbn = new BookIsbn($bookIsbn);
        $bookPhotoFile = $bookPhotoFilename !== null ? new File($bookPhotoFilename) : null;

        $bookId = $this->gateway->add(
            $authorId,
            $bookName,
            $bookDescription,
            $bookReleaseDate,
            $bookIsbn,
            $bookPhotoFile
        );

        $event = new BookHasBeenAdded($authorId->value(), $bookId->value(), $bookName->value());

        $this->trigger(BookHasBeenAdded::EVENT_NAME, $event);
    }
}