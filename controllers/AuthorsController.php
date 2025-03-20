<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\forms\authors\GetTopAuthorsByYearForm;
use app\modules\authors\actions\GetTopAuthorsByYear;
use app\modules\catalog\actions\GetAuthors;
use app\modules\reader\actions\Subscribe;
use app\utils\Permissions;
use Override;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

final class AuthorsController extends Controller
{
    private const int DEFAULT_COUNT_OF_TOP_AUTHORS = 10;

    #[Override]
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['subscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['subscribe'],
                        'permissions' => [Permissions::SubscribeToAuthor->value],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(GetAuthors $getAuthorsAction): string
    {
        $authors = $getAuthorsAction->getAuthors();

        return $this->render('index', [
            'authors' => $authors
        ]);
    }

    public function actionGetTopAuthorsByYear(GetTopAuthorsByYear $getTopAuthorsByYearAction): string
    {
        $model = new GetTopAuthorsByYearForm();

        $model->load(Yii::$app->request->post());

        $model->year = $model->year === 0 ? (int)date('Y') : $model->year;

        $topAuthors = $getTopAuthorsByYearAction->getTopAuthorsByYear($model->year, self::DEFAULT_COUNT_OF_TOP_AUTHORS);

        return $this->render('get_top_authors_by_year', [
            'model' => $model,
            'topAuthors' => $topAuthors
        ]);
    }

    public function actionSubscribe(Subscribe $subscribeAction): void
    {
        $authorId = Yii::$app->request->get('authorId');

        $subscribeAction->subscribe(Yii::$app->user->getId(), (int)$authorId);

        $this->redirect(['/authors/index']);
    }
}