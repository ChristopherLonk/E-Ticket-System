<?php

namespace App\Enum;

class Priority
{
    const PRIORITY = [
      'Low',
      'Normal',
      'High',
      'Urgent',
    ];

    public static function getEnum() {
        return self::PRIORITY;
    }
}
