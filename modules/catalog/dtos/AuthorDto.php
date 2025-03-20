<?php
declare(strict_types=1);

namespace app\modules\catalog\dtos;

final class AuthorDto
{
    public function __construct(
        public int $authorId,
        public string $authorFirstname,
        public string $authorLastname,
        public string $authorPatronymic,
    )
    {
    }
}