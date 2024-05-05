<?php

namespace App\Enum;

class Status
{
    const STATUS = [
      'backlog',
      'toDo',
      'barrier',
      'inProgress',
      'codeReview',
      'done'
    ];

    public static function getEnum()
    {
        return self::STATUS;
    }
}
