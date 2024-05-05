<?php

namespace App\Enum;

class StoryPoints
{
    const STORY_POINTS = [
      '0',
      '1',
      '2',
      '3',
      '5',
      '8',
      '13',
      '20',
      '40',
      '100'
    ];

    public static function getEnum()
    {
        return self::STORY_POINTS;
    }
}
