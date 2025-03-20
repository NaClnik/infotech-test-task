<?php

/** @var yii\web\View $this */
/** @var BookDto[] $books */

use app\modules\catalog\dtos\BookDto;
use app\utils\ApplicationUtils;
use yii\helpers\Url;

$this->title = 'Все книги';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?php

            foreach ($books as $book) {
                $authorsStr = implode(', ', $book->authors);
                $photoPath = $book->bookPhotoFilename !== null ?
                    '/' . ApplicationUtils::PHOTO_STORAGE_PATH . $book->bookPhotoFilename :
                    '/' . ApplicationUtils::PHOTO_STORAGE_PATH . 'blank.webp';

                $editUrl = Url::toRoute(['/books/edit', 'bookId' => $book->bookId]);
                $deleteUrl = Url::toRoute(['/books/delete', 'bookId' => $book->bookId]);

                $editButtonHtml = '';
                $deleteButtonHtml = '';

                if (!Yii::$app->user->isGuest && in_array(Yii::$app->user->getId(), $book->authorsIds)) {
                    $editButtonHtml = <<<EDIT_BUTTON_HTML
                        <a class="btn btn-primary" href="$editUrl">Редактировать</a>
                    EDIT_BUTTON_HTML;

                    $deleteButtonHtml = <<<DELETE_BUTTON_HTML
                        <a class="btn btn-danger" href="$deleteUrl">Удалить</a>
                    DELETE_BUTTON_HTML;

                }

                $htmlTemplate = <<<HTML
                    <div class="col-4">
                        <div class="card">
                            <img src="{$photoPath}" class="card-img-top" alt="...">
                            <div class="card-body" style="height: 250px;">
                                <h5 class="card-title">{$book->bookName}</h5>
                                <p class="card-text">
                                    {$book->bookDescription}
                                </p>
                                
                                <ul>
                                    <li>Авторы: {$authorsStr}</li>
                                    <li>ISBN: {$book->bookIsbn}</li>
                                    <li>Дата выхода: {$book->bookReleaseDate->format('d.m.Y')}</li>
                                </ul>
                                $editButtonHtml
                                $deleteButtonHtml
                            </div>
                        </div>
                    </div>
                    
                HTML;

                echo $htmlTemplate;
            }

            ?>
        </div>
    </div>
</div>
