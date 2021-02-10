<?php


namespace App\LINE;

use App\LINE\Setting;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

// class LINE_CONFIG {

    class Config {

    // public function __construct()
    // {

    // }

    public static function config()
    {
        $setting = Setting::getSetting();
        // dd($setting);
        $settings = $setting['settings'];
        $channelSecret = $settings['bot']['channelSecret'];
            $channelToken = $settings['bot']['channelToken'];
            // $apiEndpointBase = $settings['apiEndpointBase'];
            $bot = new LINEBot(new CurlHTTPClient($channelToken), [
                'channelSecret' => $channelSecret,
                // 'endpointBase' => $apiEndpointBase, // <= Normally, you can omit this
            ]);

        //       $container['logger'] = function ($c) {
        //     $settings = $c->get('settings')['logger'];
        //     $logger = new \Monolog\Logger($settings['name']);
        //     $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        //     $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));
        //     return $logger;
        // };
            return $bot;
    }
}
