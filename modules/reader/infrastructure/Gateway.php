<?php
declare(strict_types=1);

namespace app\modules\reader\infrastructure;

use app\modules\common\props\UserId;
use app\modules\reader\IGateway;
use app\utils\Permissions;
use app\utils\Roles;
use RuntimeException;
use Yii;
use yii\db\Exception;
use yii\rbac\Role;

final class Gateway implements IGateway
{
    /**
     * @throws Exception
     */
    public function subscribe(UserId $subscriberId, UserId $authorId): void
    {
        if ($this->getIsAlreadySubscribed($subscriberId->value(), $authorId->value())) {
            throw new RuntimeException("Пользователь с id = \"{$subscriberId->value()}\" уже имеет подписку на пользователя {$authorId->value()}");
        }

        $authManager = Yii::$app->authManager;

        $isSubscriberHasAccessToSubscribe = $authManager->checkAccess($subscriberId->value(), Permissions::SubscribeToAuthor->value);
        if (!$isSubscriberHasAccessToSubscribe) {
            throw new RuntimeException("Пользователь с id = \"{$subscriberId->value()}\" не имеет прав на подписку");
        }

        $authorRoles = $authManager->getRolesByUser($authorId->value());

        $isAuthorHasAuthorRole = $this->isUserHasAuthorRole($authorId->value(), $authorRoles);
        if (!$isAuthorHasAuthorRole) {
            throw new RuntimeException("Возможно сделать подписку только на автора. Переданный authorId = \"{$authorId->value()}\" не является автором");
        }

        Yii::$app->getDb()->createCommand()
            ->insert('{{%subscribers}}', [
                'subscriber_id' => $subscriberId->value(),
                'author_id' => $authorId->value()
            ])->execute();
    }

    /**
     * @throws Exception
     */
    private function getIsAlreadySubscribed(int $subscriberId, int $authorId): bool
    {
        $query = <<<SQL
            SELECT COUNT(1) AS is_already_subscribed
            FROM subscribers
            WHERE subscriber_id = :subscriber_id AND author_id = :author_id
            LIMIT 1
        SQL;

        $command = Yii::$app->getDb()->createCommand($query, [
            ':subscriber_id' => $subscriberId,
            ':author_id' => $authorId
        ]);

        $result = $command->queryScalar();

        return $result === 1;
    }

    /**
     * @param Role[] $roles
     */
    private function isUserHasAuthorRole (int $userId, array $roles): bool
    {
        $isUserHasAuthorRole = false;

        foreach ($roles as $role) {
            if ($role->name === Roles::Author->value) {
                $isUserHasAuthorRole = true;
                break;
            }
        }

        return $isUserHasAuthorRole;
    }
}