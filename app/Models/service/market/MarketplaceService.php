<?php

namespace App\Models\service\market;

use GuzzleHttp\RequestOptions;

/**
 * Базовый класс для сервиса маркетплейса.
 */
abstract class MarketplaceService
{
    private string $proxy;

    public function __construct()
    {
        $this->proxy = 'http://localhost' . ':2346';
    }

    /**
     * Стандартный путь до логотипа.
     */
    private const LOGO_PATH = 'assets/img/market/';

    /**
     * Метод получения полного пути до логотипа.
     *
     * @return string Путь до логотипа.
     */
    public function getLogoPath(): string
    {
        return self::LOGO_PATH . $this->getSign() . static::LOGO_EXTENSION;
    }

    /**
     * Метод получения подписи (названия) маркетплейса.
     *
     * @return string Подпись (название) маркетплейса. Например, "wildberries".
     */
    public abstract function getSign(): string;

    /**
     * Метод поиска подходящих товаров по текстовому запросу.
     *
     * @param string $query Текстовый запрос.
     * @return array Массив подходящих товаров.
     */
    public abstract function search(string $query): array;

    public function proxyRequest($url)
    {
        $proxyStorage = [
            'user177273:ez3pc5@45.88.211.188:5759',
            'WToXFe:eFG2mj@194.124.50.95:8000'
        ];

        $proxies = [
            'http' => $proxyStorage[array_rand($proxyStorage)],
            'https' => $proxyStorage[array_rand($proxyStorage)],
        ];

        $client = new \GuzzleHttp\Client(
            [
                RequestOptions::PROXY => $proxies,
                RequestOptions::VERIFY => false,
                RequestOptions::TIMEOUT => 30,
            ]
        );

        $response = $client->get($url);

        var_dump(json_decode($response->getBody()));

        return json_decode($response->getBody());
    }
}
