<?php

namespace App\Models\service\market;

use App\Models\dto\ItemDto;

class WildberriesService extends MarketplaceService
{
    private const SEARCH_PATH = "https://search.wb.ru/exactmatch/ru/common/v5/search?curr=rub&dest=-1257786";

    protected const LOGO_EXTENSION = '.jpg';

    public function getSign(): string
    {
        return 'Wildberries';
    }

    public function search(string $query): array
    {
        $client = new \GuzzleHttp\Client(
            [
                'verify' => false
            ]
        );

        $query = $_GET['query'];

        $response = $client->get
        (
            self::SEARCH_PATH . "&query=$query" . '&resultset=catalog&sort=popular&limit=10'
        );

        $jsonObject = json_decode($response->getBody());

        return array_map(function ($rawItem) {
            return new ItemDto(
                $rawItem->name,
                'https://www.wildberries.ru/catalog/' . $rawItem->id . '/detail.aspx',
                $this->findPhotoUrlInBasket($rawItem),
                $rawItem->sizes[0]->price->total / 100);
        }, $jsonObject->data->products);
    }

    private function findPhotoUrlInBasket($item): string
    {
            $part = intval($item->id / 1000);
            $vol = intval($part / 100);
            $id = $item->id;

            if ($vol >= 0 && $vol <= 143) $basketNum = '01';
            else if ($vol >= 144 && $vol <= 287) $basketNum = '02';
            else if ($vol >= 288 && $vol <= 431) $basketNum = '03';
            else if ($vol >= 432 && $vol <= 719) $basketNum = '04';
            else if ($vol >= 720 && $vol <= 1007) $basketNum = '05';
            else if ($vol >= 1008 && $vol <= 1061) $basketNum = '06';
            else if ($vol >= 1062 && $vol <= 1115) $basketNum = '07';
            else if ($vol >= 1116 && $vol <= 1169) $basketNum = '08';
            else if ($vol >= 1170 && $vol <= 1313) $basketNum = '09';
            else if ($vol >= 1314 && $vol <= 1601) $basketNum = '10';
            else if ($vol >= 1602 && $vol <= 1655) $basketNum = '11';
            else if ($vol >= 1656 && $vol <= 1919) $basketNum = '12';
            else $basketNum = '13';

            return "https://basket-$basketNum.wbbasket.ru/vol$vol/part$part/$id/images/c516x688/1.webp";
    }
}