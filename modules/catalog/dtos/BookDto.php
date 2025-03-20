<?php
declare(strict_types=1);

namespace app\modules\catalog\dtos;

use DateTimeImmutable;

final class BookDto
{
    /**
     * @param string[] $authors Параметр содержит в себе массив с ФИО авторов в таком формате: "Иванов Иван Иванович".
     * @param int[] $authorsIds Параметр содержит в себе массив с id авторов.
     */
    public function __construct(
        public int $bookId,
        public string $bookName,
        public string $bookDescription,
        public DateTimeImmutable $bookReleaseDate,
        public DateTimeImmutable $bookReleaseDateOnService,
        public string $bookIsbn,
        public ?string $bookPhotoFilename,
        public array $authors,
        public array $authorsIds
    )
    {
    }
}