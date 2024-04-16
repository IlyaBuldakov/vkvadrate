<?php

namespace App\Models\service;

use App\Models\dto\MarketplaceDto;
use App\Models\service\market\SimaLandService;

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
                new SimaLandService()
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
            $items[] = new MarketplaceDto($marketplaceService->getLogoPath(), $marketplaceService->search($query));
        }
        return $items;
    }
}
