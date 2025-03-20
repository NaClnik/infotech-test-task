<?php
declare(strict_types=1);

namespace app\modules\authors\dtos;

final class TopAuthorDto
{
    public function __construct(
        public int $authorId,
        public string $authorFirstname,
        public string $authorLastname,
        public string $authorPatronymic,
        public int $countOfReleasedBooksInYear
    )
    {
    }
}