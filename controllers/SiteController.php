<?php

namespace app\controllers;

use Override;
use yii\web\Controller;

class SiteController extends Controller
{
    #[Override]
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionError(): string
    {
        return $this->render('error');
    }
}
