<?php

/** @var yii\web\View $this */
/** @var AuthorDto[] $authors */

use app\modules\catalog\dtos\AuthorDto;
use yii\helpers\Url;

$this->title = 'Все авторы';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?php
            foreach ($authors as $author) {
                $subscribeUrl = Url::toRoute(['/authors/subscribe', 'authorId' => $author->authorId]);

                $subscribeButtonHtml = '';

                if (!Yii::$app->user->isGuest) {
                    $subscribeButtonHtml = <<<SUBSCRIBE_BUTTON_HTML
                        <a href="$subscribeUrl" class="btn btn-primary">Подписаться</a>
                    SUBSCRIBE_BUTTON_HTML;
                }

                $htmlTemplate = <<<HTML
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body" style="height: 250px;">
                                <h5 class="card-title">{$author->authorLastname} {$author->authorFirstname} {$author->authorPatronymic}</h5>
                                $subscribeButtonHtml
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
