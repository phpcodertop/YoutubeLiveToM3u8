<?php

namespace phpcodertop\YoutubeLiveToM3u8\Facades;


use Illuminate\Support\Facades\Facade;

class YouTubeToM3u8Facade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'M3u8';
    }

}