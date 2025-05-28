<?php

namespace App\Services;

use App\Models\Notification;
use Exception;
class NotificationService
{

    public function confirmRead(array $data)
    {
        if (!empty($data['notifications_ids']) && is_array($data['notifications_ids'])) {
            return Notification::whereIn('id', $data['notifications_ids'])
                ->update(['read_at' => now()]);
        }

        return false;
    }

}