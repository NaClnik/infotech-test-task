<?php
declare(strict_types=1);

namespace app\modules\book\actions;
use app\modules\book\IGateway;
use app\modules\common\props\BookId;
use app\modules\common\props\UserId;

final readonly class Delete
{
    public function __construct(
        private IGateway $gateway
    )
    {
    }

    public function delete(int $editorId, int $bookId): void
    {
        $editorId = new UserId($editorId);
        $bookId = new BookId($bookId);

        $this->gateway->delete($editorId, $bookId);
    }
}