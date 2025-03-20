<?php

namespace app\commands;

use app\utils\Permissions;
use app\utils\Roles;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;


class RbacController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionInitializeRolesAndPermissions(): int
    {
        $auth = Yii::$app->authManager;

        $subscribeToAuthorPermission = $auth->createPermission(Permissions::SubscribeToAuthor->value);
        $subscribeToAuthorPermission->description = 'Подписка на автора';
        $auth->add($subscribeToAuthorPermission);

        $viewBookPermission = $auth->createPermission(Permissions::ViewBook->value);
        $viewBookPermission->description = 'Просмотр книги';
        $auth->add($viewBookPermission);

        $addBookPermission = $auth->createPermission(Permissions::AddBook->value);
        $addBookPermission->description = 'Добавление книги';
        $auth->add($addBookPermission);

        $updateBookPermission = $auth->createPermission(Permissions::UpdateBook->value);
        $updateBookPermission->description = 'Редактирование книги';
        $auth->add($updateBookPermission);

        $deleteBookPermission = $auth->createPermission(Permissions::DeleteBook->value);
        $deleteBookPermission->description = 'Удаление книги';
        $auth->add($deleteBookPermission);

        $readerRole = $auth->createRole(Roles::Reader->value);
        $auth->add($readerRole);
        $auth->addChild($readerRole, $subscribeToAuthorPermission);
        $auth->addChild($readerRole, $viewBookPermission);

        $authorRole = $auth->createRole(Roles::Author->value);
        $auth->add($authorRole);
        $auth->addChild($authorRole, $viewBookPermission);
        $auth->addChild($authorRole, $addBookPermission);
        $auth->addChild($authorRole, $updateBookPermission);
        $auth->addChild($authorRole, $deleteBookPermission);

        return ExitCode::OK;
    }
}
