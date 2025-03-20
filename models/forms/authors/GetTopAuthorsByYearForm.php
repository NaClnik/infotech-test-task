<?php
declare(strict_types=1);

namespace app\models\forms\authors;

use Override;
use yii\base\Model;

final class GetTopAuthorsByYearForm extends Model
{
    public int $year = 0;

    #[Override]
    public function rules(): array
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer', 'min' => 0, 'max' => (int)date('Y')],
        ];
    }
}