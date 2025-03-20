<?php
declare(strict_types=1);

namespace app\modules\catalog\actions;

use app\modules\catalog\dtos\AuthorDto;
use app\modules\catalog\IDataProvider;

final readonly class GetAuthors
{
    public function __construct(
        private IDataProvider $dataProvider
    )
    {
    }

    /** @return AuthorDto[] */
    public function getAuthors(): array
    {
        return $this->dataProvider->getAuthors();
    }
}