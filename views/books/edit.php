<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var AddBookForm $model */
/** @var int $bookId */

use app\models\forms\auth\RegisterForm;
use app\models\forms\books\AddBookForm;
use app\utils\Roles;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Редактирование книги';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-add-book">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Заполните форму для добавления новой книги</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'edit-book-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'editorId')->hiddenInput(['value' => Yii::$app->user->getId()]) ?>
            <?= $form->field($model, 'bookId')->hiddenInput(['value' => $bookId]) ?>
            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'description')->textInput() ?>

            <?= $form->field($model, 'bookReleaseDate')->textInput() ?>
            <?= $form->field($model, 'isbn')->textInput() ?>
            <?= $form->field($model, 'bookPhoto')->fileInput() ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Редактировать книгу', ['class' => 'btn btn-primary', 'name' => 'edit-book-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
