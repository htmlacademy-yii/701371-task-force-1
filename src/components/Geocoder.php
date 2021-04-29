<?php

namespace TaskForce\components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\helpers\Json;

/**
 * @note
 * class for working with geocoder (yandex map)
 *
 * Class Geocoder
 * @package TaskForce\components
 */
class Geocoder
{
    public string $apiKey;
    private string $lang = 'ru_RU';
    private string $format = 'json';

    /**
     * @note
     * get coordinates for current city
     *
     * @param string $cityName
     * @return array
     * @throws GuzzleException
     */
    public function getCoordinates(string $cityName): array
    {
        return $this->sendRequest($cityName);
    }

    /**
     * @note
     * use GuzzleHttp, for install: composer require guzzlehttp/guzzle:^7.0
     * for http requests
     *
     * @param $cityName
     * @return mixed
     * @throws GuzzleException
     */
    private function sendRequest($cityName)
    {
        /**
         * @note
         * md5 - hashes the data, you need the key to be cast to the same type
         * and that its length is always 32 characters, and that there is a single value
         * any encoding even that I don't have
         */
        $cacheKey = md5($cityName);

        /**
         * @note
         * if the value is already in the cache,
         * then we get it from the cache
         */
        if (Yii::$app->cache->exists($cacheKey)) {
            return Json::decode(Yii::$app->cache->get($cacheKey));
        }

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

        /** @note writing the value to the cache */
        Yii::$app->cache->set($cacheKey, $content, 60 * 60 * 24);

        return Json::decode($content);
    }
}
