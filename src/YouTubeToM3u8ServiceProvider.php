<?php
namespace phpcodertop\YoutubeLiveToM3u8;
use Illuminate\Support\ServiceProvider;

class YouTubeToM3u8ServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('M3u8',function (){
            return new YoutubeLiveToM3u8;
        });
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {

    }



}