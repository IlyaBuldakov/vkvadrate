<?php

namespace App\Models\service\market;

use App\Models\dto\ItemDto;
use Facebook\WebDriver\Firefox\FirefoxDriver;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class YandexMarketService extends MarketplaceService
{

    public const LOGO_EXTENSION = '.jpg';

    private const SEARCH_PATH = "https://market.yandex.ru/search-redirect";

    private const GECKO_EXE_PATH = '/snap/bin/geckodriver';

    public function __construct()
    {
        $desiredCapabilities = DesiredCapabilities::firefox();
        $desiredCapabilities->setCapability('acceptSslCerts', false);

        $firefoxOptions = new FirefoxOptions();
        $firefoxOptions->addArguments(['-headless']);

        $desiredCapabilities->setCapability(FirefoxOptions::CAPABILITY, $firefoxOptions);

        putenv('WEBDRIVER_FIREFOX_DRIVER=' . self::GECKO_EXE_PATH);

        define('DRIVER', FirefoxDriver::start($desiredCapabilities));
    }

    public function getSign(): string
    {
        return 'YandexMarket';
    }

    public function search(string $query): array
    {
        $driver = constant('DRIVER');

        if (!$driver) {
            var_dump('Яндекс / Драйвер не создан, создаём');
            $this->__construct();
        }

        $driver->get(self::SEARCH_PATH . "?text=$query");

        var_dump('Яндекс / Зашел на страницу');

        var_dump($driver->getWindowHandles());
        $driver->takeScreenshot('photoLog');

        $allProducts = $driver->executeScript("
                        var block = document.querySelector('[data-auto=\"search-vendor-incut\"]');
                        if (block !== null) { block.remove(); }

                        var productSnippets = document.querySelectorAll('[data-baobab-name=\"productSnippet\"]');

                        var data = [];

                        let count = productSnippets.length;
                        let upperBound = count <= 10 ? count : 10;

                        for (let i = 0; i < 10; i++) {
                            if (productSnippets[i]) {
                                var elem = productSnippets[i].firstChild.firstChild.children;

                                if (!elem || elem.length == 0) {
                                    elem = productSnippets[i].firstChild.children.item(1).children;
                                }

                                var imageParent = elem.item(0);

                                if (imageParent !== null && imageParent.firstChild !== null) {

                                    var imageDivs = imageParent.firstChild.firstChild;

                                    if (imageDivs.children.item(0).tagName.toLowerCase() == 'script') {
                                        imageDivs = imageDivs.children.item(1);
                                    } else {
                                        imageDivs = imageDivs.children.item(0);
                                    }

                                    var imgAndVideoContainer = imageDivs.children.item(0).children.item(0).children.item(0).children.item(0).children.item(0);

                                    var imageResult = imgAndVideoContainer.children.item(0).tagName.toLowerCase() === 'img'
                                                      ? imgAndVideoContainer.children.item(0).src
                                                      : imgAndVideoContainer.children.item(1).src;

                                    var titleParent = elem.item(1);
                                    var a = titleParent.firstChild.firstChild.firstChild;
                                    var itemUrl = a.href;
                                    var title = a.firstChild.innerHTML;

                                    var priceParent = elem.item(2);

                                    if (priceParent.children.item(1)) {
                                        // с картой Пэй
                                        var price = priceParent.children.item(1).firstChild.firstChild.firstChild.firstChild.firstChild.children.item(1).firstChild.firstChild.innerHTML;
                                        data.push(
                                        {
                                             \"title\": title,
                                             \"price\": price,
                                             \"imageUrl\": imageResult,
                                             \"itemUrl\": itemUrl
                                        });
                                    }
                                }
                            }
                        }
                        return data;
                        ");

        var_dump('Яндекс / Безголовый браузер выполнил скрипт для парсинга');

        return array_map(function ($rawItem) {
            var_dump('Яндекс / Рисует товар');
            return new ItemDto(
                $rawItem->title,
                $rawItem->itemUrl,
                $rawItem->imageUrl,
                $rawItem->price);
        }, json_decode(json_encode($allProducts)));
    }
}
