<?php
declare(strict_types=1);

namespace app\modules\system\notifications\infrastructure;

use app\modules\book\props\BookName;
use app\modules\common\props\BookId;
use app\modules\common\props\UserId;
use app\modules\system\notifications\IGateway;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\db\Exception;

final class Gateway implements IGateway
{
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendSmsAboutNewBookForSubscribers(UserId $authorId, BookId $bookId, BookName $bookName): void
    {
        $subscribersPhoneNumbers = $this->getSubscribersPhoneNumbers($authorId->value());

        $authorName = $this->getAuthorName($authorId->value());
        $message = "Вышла новая книга \"{$bookName->value()}\" от автора \"$authorName\"!";

        foreach ($subscribersPhoneNumbers as $subscriberPhoneNumber) {
            $client = new Client();

            $client->get('https://smspilot.ru/api.php', [
                'query' => [
                    'send' => $message,
                    'to' => $subscriberPhoneNumber,
                    'api_key' => env('SMS_PILOT_API_KEY'),
                    'test' => '1'
                ]
            ]);
        }
    }

    /** @return string[] Возвращает массив с номерами телефонов подписчиков автора
     * @throws Exception
     */
    private function getSubscribersPhoneNumbers(int $authorId): array
    {
        $query = <<<SQL
            SELECT t_u.user_phone_number
            FROM users t_u
              INNER JOIN subscribers t_s ON t_u.user_id = t_s.subscriber_id
            WHERE t_s.author_id = :authorId;
        SQL;


        $command = Yii::$app->db->createCommand($query, [
            ':authorId' => $authorId,
        ]);

        return $command->queryColumn();
    }

    /**
     * @throws Exception
     */
    private function getAuthorName(int $authorId): string
    {
        $query = <<<SQL
            SELECT CONCAT(user_lastname, ' ', user_firstname, ' ', user_patronymic)
            FROM users
            WHERE user_id = :authorId
            LIMIT 1;
        SQL;

        $command = Yii::$app->db->createCommand($query, [
            ':authorId' => $authorId,
        ]);

        return $command->queryScalar();
    }
}