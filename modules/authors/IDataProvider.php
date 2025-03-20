<?php
declare(strict_types=1);


namespace app\modules\authors;

use app\modules\authors\dtos\TopAuthorDto;
use app\modules\common\props\Count;
use app\modules\common\props\Year;

interface IDataProvider
{
    /** @return TopAuthorDto[] */
    public function getTopAuthorsByYear(Year $year, Count $countOfAuthors): array;
}