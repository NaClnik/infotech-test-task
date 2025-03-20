<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\forms\auth\LoginForm;
use app\models\forms\auth\RegisterForm;
use app\models\User;
use app\modules\user\auth\actions\Register;
use Override;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

final class AuthController extends Controller
{
    #[Override]
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionRegister(Register $registerAction): Response|string
    {
        $request = Yii::$app->request;

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();

        if ($model->load($request->post()) && $request->isPost) {
            $registerAction->register(
                $model->email,
                $model->password,
                $model->phoneNumber,
                $model->firstname,
                $model->lastname,
                $model->patronymic,
                $model->role
            );

            $user = User::findByUsername($model->email);
            Yii::$app->user->login($user);

            return $this->goHome();
        }

        $model->load([]);

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}