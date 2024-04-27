<?php

use App\Models\dto\MarketplaceDto;
use App\Models\service\market\WildberriesService;
use App\Models\service\market\YandexMarketService;
use Workerman\Worker;

require_once '../../../../vendor/autoload.php';

$marketplaceServices =
    [
        new WildberriesService(),
        new YandexMarketService(),
    ];

$ws_worker = new Worker('websocket://127.0.0.1:2345');

$ws_worker->onConnect = function ($connection) {
    echo "Соединение открыто\n";
};

$ws_worker->onMessage = function ($connection, $data) use ($marketplaceServices) {
    $preparedData = explode(',', $data);
    foreach ($marketplaceServices as $marketplaceService) {
        if (in_array($marketplaceService->getSign(), explode(',', $preparedData[0])) ||
            $preparedData[0] === 'all') {
            $connection->send(
                (new MarketplaceDto(
                    $marketplaceService->getLogoPath(), $marketplaceService->search($preparedData[1]), $marketplaceService->getSign()
                ))->__toString()
            );
        }
    }
};

$ws_worker->onClose = function ($connection) {
    echo "Соединение закрыто\n";
};

Worker::runAll();
