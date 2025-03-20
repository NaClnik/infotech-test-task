<?php
declare(strict_types=1);

namespace app\modules\reader\actions;

use app\modules\common\props\UserId;
use app\modules\reader\IGateway;

final readonly class Subscribe
{
    public function __construct(
        private IGateway $gateway
    )
    {
    }

    public function subscribe(int $subscriberId, int $authorId): void
    {
        $subscriberId = new UserId($subscriberId);
        $authorId = new UserId($authorId);

        $this->gateway->subscribe($subscriberId, $authorId);
    }
}