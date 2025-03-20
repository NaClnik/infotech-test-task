<?php
declare(strict_types=1);

namespace app\modules\catalog\actions;

use app\modules\catalog\dtos\BookDto;
use app\modules\catalog\IDataProvider;

final readonly class GetBooks
{
    public function __construct(
        private IDataProvider $dataProvider
    )
    {
    }

    /** @return BookDto[] */
    public function getBooks(): array
    {
        return $this->dataProvider->getBooks();
    }
}