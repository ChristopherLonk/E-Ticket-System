<?php

namespace App;

class Tools
{
    static function randomByte()
    {
        $bytes = random_bytes(64);
        return bin2hex($bytes);
    }
}
