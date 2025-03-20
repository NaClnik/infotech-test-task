<?php
declare(strict_types=1);

namespace app\modules\catalog\infrastructure;

use app\modules\catalog\dtos\AuthorDto;
use app\modules\catalog\dtos\BookDto;
use app\modules\catalog\IDataProvider;
use app\modules\common\props\BookId;
use app\utils\Roles;
use DateTimeImmutable;
use Yii;
use yii\db\Exception;

final class DataProvider implements IDataProvider
{
    /** @return BookDto[]
     * @throws Exception
     */
    public function getBooks(): array
    {
        $query = <<<SQL
            SELECT
              t_b.book_id,
              t_b.book_name,
              t_b.book_description,
              t_b.book_release_date,
              t_b.book_release_date_on_service,
              t_b.book_isbn,
              t_b.book_photo_filename,
              group_concat(CONCAT(t_u.user_lastname, ' ', t_u.user_firstname, ' ', t_u.user_patronymic)) as book_grouped_authors,
              group_concat(t_u.user_id) as book_grouped_authors_ids
            FROM books t_b
              INNER JOIN books_authors t_ba ON t_b.book_id = t_ba.book_id
              INNER JOIN users t_u ON t_ba.author_id = t_u.user_id
            WHERE t_b.book_is_deleted = FALSE
            GROUP BY
              t_b.book_id,
              t_b.book_name,
              t_b.book_description,
              t_b.book_release_date,
              t_b.book_release_date_on_service,
              t_b.book_isbn,
              t_b.book_photo_filename;
        SQL;

        $command = \Yii::$app->getDb()->createCommand($query);

        $data = $command->queryAll();

        $result = [];

        foreach ($data as $item) {
            $result[] = new BookDto(
                $item['book_id'],
                $item['book_name'],
                $item['book_description'],
                DateTimeImmutable::createFromFormat('Y-m-d', $item['book_release_date']),
                DateTimeImmutable::createFromFormat('Y-m-d', $item['book_release_date_on_service']),
                $item['book_isbn'],
                $item['book_photo_filename'],
                explode(',', $item['book_grouped_authors']),
                array_map(function (string $item) {
                    return (int)$item;
                }, explode(',', $item['book_grouped_authors_ids']))
            );
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function getBook(BookId $bookId): BookDto
    {
        $query = <<<SQL
            SELECT
              t_b.book_id,
              t_b.book_name,
              t_b.book_description,
              t_b.book_release_date,
              t_b.book_release_date_on_service,
              t_b.book_isbn,
              t_b.book_photo_filename,
              group_concat(CONCAT(t_u.user_lastname, ' ', t_u.user_firstname, ' ', t_u.user_patronymic)) as book_grouped_authors,
              group_concat(t_u.user_id) as book_grouped_authors_ids
            FROM books t_b
              INNER JOIN books_authors t_ba ON t_b.book_id = t_ba.book_id
              INNER JOIN users t_u ON t_ba.author_id = t_u.user_id
            WHERE t_b.book_id = :bookId AND t_b.book_is_deleted = FALSE
            GROUP BY
              t_b.book_id,
              t_b.book_name,
              t_b.book_description,
              t_b.book_release_date,
              t_b.book_release_date_on_service,
              t_b.book_isbn,
              t_b.book_photo_filename
            LIMIT 1;
        SQL;

        $command = \Yii::$app->getDb()->createCommand($query, [
            ':bookId' => $bookId->value()
        ]);

        $data = $command->queryOne();

        return new BookDto(
            $data['book_id'],
            $data['book_name'],
            $data['book_description'],
            DateTimeImmutable::createFromFormat('Y-m-d', $data['book_release_date']),
            DateTimeImmutable::createFromFormat('Y-m-d', $data['book_release_date_on_service']),
            $data['book_isbn'],
            $data['book_photo_filename'],
            explode(',', $data['book_grouped_authors']),
            array_map(function (string $item) {
                return (int)$item;
            }, explode(',', $data['book_grouped_authors_ids']))
        );
    }

    /** @return AuthorDto[]
     * @throws Exception
     */
    public function getAuthors(): array
    {
        $query = <<<SQL
            SELECT
              t_u.user_id,
              t_u.user_firstname,
              t_u.user_lastname,
              t_u.user_patronymic
            FROM users t_u
                   INNER JOIN auth_assignment t_aa ON t_u.user_id = CAST(t_aa.user_id AS SIGNED)
            WHERE t_aa.item_name = :authorRole
        SQL;

        $command = Yii::$app->getDb()->createCommand($query, [
            ':authorRole' => Roles::Author->value
        ]);

        $data = $command->queryAll();

        $result = [];

        foreach ($data as $item) {
            $result[] = new AuthorDto(
                $item['user_id'],
                $item['user_firstname'],
                $item['user_lastname'],
                $item['user_patronymic'],
            );
        }

        return $result;
    }
}