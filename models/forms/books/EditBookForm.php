<?php
declare(strict_types=1);

namespace app\models\forms\books;

use Override;
use yii\base\Model;
use yii\web\UploadedFile;

final class EditBookForm extends Model
{
    public int $editorId = 0;
    public int $bookId = 0;
    public string $name = '';
    public string $description = '';
    public string $bookReleaseDate = '';
    public string $isbn = '';

    /** @var UploadedFile $bookPhoto */
    public $bookPhoto;

    #[Override]
    public function rules(): array
    {
        return [
            [['editorId', 'bookId', 'name', 'description', 'bookReleaseDate', 'isbn'], 'required'],
            [['name', 'description', 'isbn'], 'string'],
            ['bookReleaseDate', 'date', 'format' => 'Y-m-d'],
            [['bookPhoto'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }
}