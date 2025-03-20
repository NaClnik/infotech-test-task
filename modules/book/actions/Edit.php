<?php
declare(strict_types=1);

namespace app\modules\book\actions;

use app\modules\book\IGateway;
use app\modules\book\props\BookDescription;
use app\modules\book\props\BookIsbn;
use app\modules\book\props\BookName;
use app\modules\common\props\BookId;
use app\modules\common\props\File;
use app\modules\common\props\UserId;
use DateTimeImmutable;

final readonly class Edit
{
    public function __construct(
        private IGateway $gateway
    )
    {
    }

    public function edit(
        int $editorId,
        int $bookId,
        string $bookName,
        string $bookDescription,
        DateTimeImmutable $bookReleaseDate,
        string $bookIsbn,
        ?string $bookPhotoFilename
    ): void
    {
        $editorId = new UserId($editorId);
        $bookId = new BookId($bookId);
        $bookName = new BookName($bookName);
        $bookDescription = new BookDescription($bookDescription);
        $bookIsbn = new BookIsbn($bookIsbn);
        $bookPhotoFile = $bookPhotoFilename !== null ? new File($bookPhotoFilename) : null;

        $this->gateway->edit(
            $editorId,
            $bookId,
            $bookName,
            $bookDescription,
            $bookReleaseDate,
            $bookIsbn,
            $bookPhotoFile
        );
    }
}