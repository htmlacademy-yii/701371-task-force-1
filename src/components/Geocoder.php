<?php

namespace TaskForce\components;

use GuzzleHttp\Client;
use yii\helpers\Json;

/**
 * NOTE:
 * Class for working with geocoder (yandex map)
 */
class Geocoder
{
    public $apiKey;
    private $lang = 'ru_RU';
    private $format = 'json';

    public function getCoordinates(string $cityName): array
    {
        return $this->sendRequest($cityName);
    }

    /*
     * NOTE:
     * use GuzzleHttp, for install: composer require guzzlehttp/guzzle:^7.0
     * for http requests
     * */
    private function sendRequest($cityName)
    {
        $client = new Client([
            'base_uri' => 'https://geocode-maps.yandex.ru/1.x',
        ]);

        $response = $client->request('GET', '', [
            'query' => [
                'geocode' => $cityName,
                'apikey' => $this->apiKey,
                'format' => $this->format,
                'lang' => $this->lang,
            ],
        ]);

        $content = $response->getBody()->getContents();

        return Json::decode($content);
    }
}
