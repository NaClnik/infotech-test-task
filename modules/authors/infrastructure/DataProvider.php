<?php
declare(strict_types=1);

namespace app\modules\authors\infrastructure;

use app\modules\authors\dtos\TopAuthorDto;
use app\modules\authors\IDataProvider;
use app\modules\common\props\Count;
use app\modules\common\props\Year;
use Yii;
use yii\db\Exception;

final class DataProvider implements IDataProvider
{
    /**
     * @return TopAuthorDto[]
     * @throws Exception
     */
    public function getTopAuthorsByYear(Year $year, Count $countOfAuthors): array
    {
        $query = <<<SQL
            SELECT
              t_u.user_id,
              t_u.user_firstname,
              t_u.user_lastname,
              t_u.user_patronymic,
              COUNT(t_b.book_id) AS count_of_released_books_in_year
            FROM users t_u
              INNER JOIN books_authors t_ba ON t_u.user_id = t_ba.author_id
              INNER JOIN books t_b ON t_ba.book_id = t_b.book_id
            WHERE YEAR(t_b.book_release_date_on_service) = :year AND t_b.book_is_deleted = FALSE
            GROUP BY
              t_u.user_id,
              t_u.user_firstname,
              t_u.user_lastname,
              t_u.user_patronymic
            ORDER BY count_of_released_books_in_year DESC
            LIMIT :count_of_authors
        SQL;

        $command = Yii::$app->getDb()->createCommand($query, [
            ':year' => $year->value(),
            ':count_of_authors' => $countOfAuthors->value(),
        ]);

        $data = $command->queryAll();

        $result = [];

        foreach ($data as $item) {
            $result[] = new TopAuthorDto(
                $item['user_id'],
                $item['user_firstname'],
                $item['user_lastname'],
                $item['user_patronymic'],
                $item['count_of_released_books_in_year']
            );
        }

        return $result;
    }
}