<?php

namespace App\Models\service;

use App\Models\dto\MarketplaceDto;
use App\Models\service\market\SimaLandService;
use App\Models\service\market\WildberriesService;
use App\Models\service\market\YandexMarketService;

/**
 * Сервис для поиска товаров.
 */
class CommonSearchService
{
    private array $marketplaceServices;

    public function __construct()
    {
        $this->marketplaceServices =
            [
                new SimaLandService(),
                new YandexMarketService(),
                new WildberriesService()
            ];
    }

    /**
     * @param string $query . Поисковый запрос.
     * @return array. Массив товаров.
     */
    public function search(string $query): array
    {
        $items = [];
        foreach ($this->marketplaceServices as $marketplaceService) {
            $items[] = new MarketplaceDto(
                $marketplaceService->getLogoPath(), $marketplaceService->search($query), $marketplaceService->getSign()
            );
        }
        return $items;
    }
}
