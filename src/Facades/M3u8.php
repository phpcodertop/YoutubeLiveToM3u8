<?php

namespace phpcodertop\YoutubeLiveToM3u8\Facades;


use Illuminate\Support\Facades\Facade;
use phpcodertop\YoutubeLiveToM3u8\YoutubeLiveToM3u8;

class M3u8 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return new YoutubeLiveToM3u8();
    }

}