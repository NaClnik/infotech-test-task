<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\forms\books\AddBookForm;
use app\models\forms\books\EditBookForm;
use app\modules\book\actions\Add;
use app\modules\book\actions\Delete;
use app\modules\book\actions\Edit;
use app\modules\catalog\actions\GetBooks;
use app\utils\Permissions;
use DateTimeImmutable;
use Override;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

final class BooksController extends Controller
{
    #[Override]
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['add', 'edit', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['add'],
                        'permissions' => [Permissions::AddBook->value],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['edit'],
                        'permissions' => [Permissions::UpdateBook->value],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'permissions' => [Permissions::DeleteBook->value],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(GetBooks $getBooksAction): string
    {
        $books = $getBooksAction->getBooks();

        return $this->render('index', [
            'books' => $books
        ]);
    }

    public function actionAdd(Add $addAction): Response|string
    {
        $model = new AddBookForm();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isPost) {
            $model->bookPhoto = UploadedFile::getInstance($model, 'bookPhoto');
            $addAction->add(
                $model->authorId,
                $model->name,
                $model->description,
                DateTimeImmutable::createFromFormat('Y-m-d', $model->bookReleaseDate),
                $model->isbn,
                $model->bookPhoto ? 'AddBookForm[bookPhoto]' : null,
            );

            return $this->redirect('/books/index');
        }

        return $this->render('add', [
            'model' => $model
        ]);
    }

    public function actionEdit(Edit $editAction): Response|string
    {
        $model = new EditBookForm();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isPost) {
            $model->bookPhoto = UploadedFile::getInstance($model, 'bookPhoto');
            $editAction->edit(
                $model->editorId,
                $model->bookId,
                $model->name,
                $model->description,
                DateTimeImmutable::createFromFormat('Y-m-d', $model->bookReleaseDate),
                $model->isbn,
                $model->bookPhoto ? 'EditBookForm[bookPhoto]' : null,
            );

            return $this->redirect('/books/index');
        }

        return $this->render('edit', [
            'model' => $model,
            'bookId' => Yii::$app->request->get('bookId')
        ]);
    }

    public function actionDelete(Delete $deleteAction): Response
    {
        $bookId = Yii::$app->request->get('bookId');

        $deleteAction->delete(Yii::$app->user->getId(), (int)$bookId);

        return $this->redirect('/books/index');
    }
}