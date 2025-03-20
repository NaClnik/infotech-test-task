<?php
declare(strict_types=1);

namespace app\modules\book\props;

use app\modules\common\props\TextNotEmpty;
use InvalidArgumentException;

final class BookIsbn extends TextNotEmpty
{
    // Количество цифр, которое должен содержать ISBN - 13.
    // До 1 января 2007 года был стандарт SBN, который содержал 10 цифр.
    // Подробнее можно почитать тут: https://en.wikipedia.org/wiki/ISBN
    // Существует много сервисов, которые конвертируют SBN в ISBN, поэтому считаем валидными только 13-значный код.
    public const int COUNT_OF_ISBN_NUMBERS = 13;

    public function __construct(string $value)
    {
        $value = trim($value);

        if (mb_strlen($value) !== self::COUNT_OF_ISBN_NUMBERS) {
            // В интерполированной строке в PHP не допускается использование констант, поэтому
            // пришлось делать переменную, которой присваиваем значение константы, чтобы интерполировать её значение.
            // Есть конечно вариант использовать sprintf, но в данном случае решил сделать так.
            $countOfIsbnNumbers = self::COUNT_OF_ISBN_NUMBERS;
            throw new InvalidArgumentException("ISBN должен содержать \"$countOfIsbnNumbers\" цифр");
        }

        // Проверяем, что каждый символ в строке является цифрой.
        if (!ctype_digit($value)) {
            throw new InvalidArgumentException("ISBN должен состоять только из цифр. Переданное значение: \"$value\"");
        }

        parent::__construct($value);
    }
}