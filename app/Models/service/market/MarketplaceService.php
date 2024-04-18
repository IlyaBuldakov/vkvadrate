<?php

namespace App\Models\service\market;

/**
 * Базовый класс для сервиса маркетплейса.
 */
abstract class MarketplaceService
{
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
}
