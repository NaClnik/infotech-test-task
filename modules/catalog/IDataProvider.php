<?php
declare(strict_types=1);

namespace app\modules\catalog;

use app\modules\catalog\dtos\AuthorDto;
use app\modules\catalog\dtos\BookDto;
use app\modules\common\props\BookId;

interface IDataProvider
{
    /** @return BookDto[] */
    public function getBooks(): array;

    public function getBook(BookId $bookId): BookDto;

    /** @return AuthorDto[] */
    public function getAuthors(): array;
}