<?php
declare(strict_types=1);

namespace app\modules\authors\actions;

use app\modules\authors\dtos\TopAuthorDto;
use app\modules\authors\IDataProvider;
use app\modules\common\props\Count;
use app\modules\common\props\Year;

final readonly class GetTopAuthorsByYear
{
    public function __construct(
        private IDataProvider $dataProvider
    )
    {
    }

    /** @return TopAuthorDto[] */
    public function getTopAuthorsByYear(int $year, int $countOfAuthors): array
    {
        $year = new Year($year);
        $countOfAuthors = new Count($countOfAuthors);

        return $this->dataProvider->getTopAuthorsByYear($year, $countOfAuthors);
    }
}