<?php
declare(strict_types=1);


namespace app\modules\book;

use app\modules\book\props\BookDescription;
use app\modules\book\props\BookIsbn;
use app\modules\book\props\BookName;
use app\modules\common\props\BookId;
use app\modules\common\props\File;
use app\modules\common\props\UserId;
use DateTimeImmutable;

interface IGateway
{
    public function delete(UserId $editorId, BookId $bookId): void;

    public function add(
        UserId $authorId,
        BookName $bookName,
        BookDescription $bookDescription,
        DateTimeImmutable $bookReleaseDate,
        BookIsbn $bookIsbn,
        ?File $bookPhotoFile
    ): BookId;

    public function edit(
        UserId $editorId,
        BookId $bookId,
        BookName $bookName,
        BookDescription $bookDescription,
        DateTimeImmutable $bookReleaseDate,
        BookIsbn $bookIsbn,
        ?File $bookPhotoFile
    ): void;
}