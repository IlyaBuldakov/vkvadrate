<?php

namespace App\Models\service\market;

use App\Models\dto\ItemDto;

/**
 * Сервис для поиска товаров по маркетплейсу "Sima Land".
 */
class SimaLandService extends MarketplaceService
{
    private const SEARCH_PATH = 'https://www.sima-land.ru/api/v3/item/?page_type=search';

    private const SIMA_API_KEY_HEADER = 'x-api-key: 8de4c439f49586e3ac53a134cb0e15dd61825b1c0dba9d55b86087b28d4e4b799c6e1ecfc213f16b47b723f7e71157d71bdf909f1959c7e01b02d296f548ef20';

    protected const LOGO_EXTENSION = '.png';

    public function getSign(): string
    {
        return 'SimaLand';
    }

    /**
     * @param string $query . Поисковый запрос.
     * @return array. Массив подходящих товаров с SimaLand.
     */
    public function search(string $query): array
    {
        $curl = curl_init(self::SEARCH_PATH . "&q=$query&per-page=10");

        curl_setopt($curl, CURLOPT_HTTPHEADER,
            [
                'Accept: application/json',
                self::SIMA_API_KEY_HEADER
            ]
        );
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $jsonObject = json_decode(curl_exec($curl));

        return array_map(function ($rawItem) {
            return new ItemDto(
                $rawItem->name,
                'https://www.sima-land.ru/' . $rawItem->itemUrl,
                $rawItem->photoUrl,
                $rawItem->price);
        }, $jsonObject->items);
    }
}
