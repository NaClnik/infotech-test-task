<?php
declare(strict_types=1);

namespace app\modules\book\infrastructure;

use app\modules\book\IGateway;
use app\modules\book\props\BookDescription;
use app\modules\book\props\BookIsbn;
use app\modules\book\props\BookName;
use app\modules\common\props\BookId;
use app\modules\common\props\File;
use app\modules\common\props\UserId;
use app\utils\ApplicationUtils;
use DateTimeImmutable;
use RuntimeException;
use Throwable;
use Yii;
use yii\db\Connection;
use yii\db\Exception;
use yii\web\UploadedFile;

final class Gateway implements IGateway
{
    /**
     * @throws Exception
     */
    public function delete(UserId $editorId, BookId $bookId): void
    {
        if (!$this->isEditorBookOwner($editorId->value(), $bookId->value())) {
            throw new RuntimeException("Пользователь с id = \"{$editorId->value()}\" не является автором для книги с id = \"{$bookId->value()}\"");
        }

        Yii::$app->getDb()->createCommand()->update('{{%books}}', [
            'book_is_deleted' => true
        ], 'book_id = :bookId', [
            ':bookId' => $bookId->value()
        ])->execute();
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function add(
        UserId $authorId,
        BookName $bookName,
        BookDescription $bookDescription,
        DateTimeImmutable $bookReleaseDate,
        BookIsbn $bookIsbn,
        ?File $bookPhotoFile
    ): BookId
    {
        $filename = null;

        if ($bookPhotoFile !== null) {
            $uploadFile = UploadedFile::getInstanceByName($bookPhotoFile->name());

            $filename = Yii::$app->getSecurity()->generateRandomString() . '.' . $uploadFile->extension;

            $uploadFile->saveAs(ApplicationUtils::PHOTO_STORAGE_PATH . $filename);
        }

        $insertedBookId = null;

        Yii::$app->getDb()->transaction(function (Connection $db) use (
            $authorId,
            $filename,
            $bookIsbn,
            $bookReleaseDate,
            $bookDescription,
            $bookName,
            &$insertedBookId
        ) {
            $db->createCommand()->insert('{{%books}}', [
                'book_name' => $bookName->value(),
                'book_description' => $bookDescription->value(),
                'book_release_date' => $bookReleaseDate->format('Y-m-d'),
                'book_isbn' => $bookIsbn->value(),
                'book_photo_filename' => $filename
            ])->execute();

            $insertedBookId = (int)$db->getLastInsertID();

            $db->createCommand()->insert('{{%books_authors}}', [
                'author_id' => $authorId->value(),
                'book_id' => $insertedBookId
            ])->execute();
        });

        return new BookId((int)$insertedBookId);
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function edit(
        UserId $editorId,
        BookId $bookId,
        BookName $bookName,
        BookDescription $bookDescription,
        DateTimeImmutable $bookReleaseDate,
        BookIsbn $bookIsbn,
        ?File $bookPhotoFile
    ): void
    {
        if (!$this->isEditorBookOwner($editorId->value(), $bookId->value())) {
            throw new RuntimeException("Пользователь с id = \"{$editorId->value()}\" не является автором для книги с id = \"{$bookId->value()}\"");
        }

        $filename = null;

        if ($bookPhotoFile !== null) {
            $uploadFile = UploadedFile::getInstanceByName($bookPhotoFile->name());

            $filename = Yii::$app->getSecurity()->generateRandomString() . '.' . $uploadFile->extension;

            $uploadFile->saveAs(ApplicationUtils::PHOTO_STORAGE_PATH . $filename);
        }
        
        Yii::$app->getDb()->createCommand()->update('{{%books}}', [
            'book_name' => $bookName->value(),
            'book_description' => $bookDescription->value(),
            'book_release_date' => $bookReleaseDate->format('Y-m-d'),
            'book_isbn' => $bookIsbn->value(),
            'book_photo_filename' => $filename
        ], 'book_id = :bookId', [
            ':bookId' => $bookId->value()
        ])->execute();
    }

    /**
     * @throws Exception
     */
    private function isEditorBookOwner(int $editorId, int $bookId): bool
    {
        $query = <<<SQL
            SELECT COUNT(1) as is_editor_book_owner
            FROM books_authors
            WHERE author_id = :editorId AND book_id = :bookId
            LIMIT 1;
        SQL;

        $command = Yii::$app->db->createCommand($query, [
            ':editorId' => $editorId,
            ':bookId' => $bookId
        ]);

        return $command->queryScalar() === 1;
    }
}