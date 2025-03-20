<?php
declare(strict_types=1);

namespace app\modules\catalog\actions;

use app\modules\catalog\dtos\BookDto;
use app\modules\catalog\IDataProvider;
use app\modules\common\props\BookId;

final readonly class GetBook
{
    public function __construct(
        private IDataProvider $dataProvider
    )
    {
    }

    public function getBook(int $bookId): BookDto
    {
        $bookId = new BookId($bookId);

        return $this->dataProvider->getBook($bookId);
    }

}