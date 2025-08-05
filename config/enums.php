<?php

use App\Enums\Status;

return [
    'status_colors' => [
        Status::PENDING->value => '#7fbae0',
        Status::APPROVED->value => '#218737',
        Status::REJECTED->value => '#ad0404',
    ],

    'status_labels' => [
        Status::PENDING->value => 'قيد المراجعة',
        Status::APPROVED->value => 'موافقة',
        Status::REJECTED->value => 'مرفوضة',
    ],

];
