<?php

use yii\di\Container;

return [
    'definitions' => [
        // System/Notifications.
        \app\modules\system\notifications\IGateway::class => \app\modules\system\notifications\infrastructure\Gateway::class,

        // Catalog.
        \app\modules\catalog\actions\GetBooks::class => \app\modules\catalog\actions\GetBooks::class,
        \app\modules\catalog\actions\GetBook::class => \app\modules\catalog\actions\GetBook::class,
        \app\modules\catalog\actions\GetAuthors::class => \app\modules\catalog\actions\GetAuthors::class,
        \app\modules\catalog\IDataProvider::class => \app\modules\catalog\infrastructure\DataProvider::class,

        // Authors.
        \app\modules\authors\actions\GetTopAuthorsByYear::class => \app\modules\authors\actions\GetTopAuthorsByYear::class,
        \app\modules\authors\IDataProvider::class => \app\modules\authors\infrastructure\DataProvider::class,

        // Reader.
        \app\modules\reader\actions\Subscribe::class => \app\modules\reader\actions\Subscribe::class,
        \app\modules\reader\IGateway::class => \app\modules\reader\infrastructure\Gateway::class,

        // Book.
        \app\modules\book\actions\Delete::class => \app\modules\book\actions\Delete::class,
        \app\modules\book\actions\Add::class => function (Container $container) {
            $addAction = new \app\modules\book\actions\Add(new \app\modules\book\infrastructure\Gateway());

            $sendSmsAboutNewBookForSubscribersListener =
                new \app\modules\system\notifications\listeners\SendSmsAboutNewBookForSubscribers(new \app\modules\system\notifications\infrastructure\Gateway());

            $addAction->on(\app\modules\book\events\BookHasBeenAdded::EVENT_NAME, [$sendSmsAboutNewBookForSubscribersListener, 'handle']);

            return $addAction;
        },
        \app\modules\book\actions\Edit::class => \app\modules\book\actions\Edit::class,
        \app\modules\book\IGateway::class => \app\modules\book\infrastructure\Gateway::class,

        // User/Auth.
        \app\modules\user\auth\actions\Register::class => \app\modules\user\auth\actions\Register::class,
        \app\modules\user\auth\IGateway::class => \app\modules\user\auth\infrastructure\Gateway::class,
    ],
];