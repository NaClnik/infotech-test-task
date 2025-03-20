<?php

/** @var yii\web\View $this */
/** @var GetTopAuthorsByYearForm $model */
/** @var TopAuthorDto[] $topAuthors */

use app\models\forms\authors\GetTopAuthorsByYearForm;
use app\modules\authors\dtos\TopAuthorDto;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Все авторы';
?>
<div class="site-index">
    <div class="body-content">
        <?php $form = ActiveForm::begin([
            'id' => 'add-book-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'year')->input('number') ?>
        <?= Html::submitButton('Принять', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>

        <?php ActiveForm::end(); ?>

        <div class="row">
            <?php
            foreach ($topAuthors as $author) {
                $htmlTemplate = <<<HTML
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body" style="height: 250px;">
                                <h5 class="card-title">{$author->authorLastname} {$author->authorFirstname} {$author->authorPatronymic}</h5>
                                <p>Количество выпущенных книг в году: {$author->countOfReleasedBooksInYear}</p>
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
