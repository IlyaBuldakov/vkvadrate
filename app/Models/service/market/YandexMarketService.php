<?php

namespace App\Models\service\market;

use App\Models\dto\ItemDto;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\NoSuchWindowException;
use Facebook\WebDriver\Exception\SessionNotCreatedException;
use Facebook\WebDriver\Firefox\FirefoxDriver;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use GuzzleHttp\Client;

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
        $driver->get(self::SEARCH_PATH . "?text=$query");

        $allProducts = $driver->executeScript("

                        var productSnippets = document.querySelectorAll('[data-baobab-name=\"productSnippet\"]');

                        var data = [];

                        let count = productSnippets.length;
                        let upperBound = count <= 10 ? count : 10;

                        for (let i = 0; i < 10; i++) {

                                var isFromWhiteBox = false;

                                var elem = productSnippets[i].firstChild.firstChild.children;

                                if (elem === null) {
                                    isFromWhiteBox = true;
                                    elem = productSnippets[i].firstChild.children.item(1).children;
                                }

                                if (!isFromWhiteBox) {

                                    var imageParent = elem.item(0);

                                    var imageDivs = imageParent.firstChild.firstChild.children.item(0);
                                    var imageResult = imageDivs.children.item(0).children.item(0).children.item(0).children.item(0).children.item(0).children.item(0).src

                                    var titleParent = elem.item(1);
                                    var a = titleParent.firstChild.firstChild.firstChild;
                                    var itemUrl = a.href;
                                    var title = a.firstChild.innerHTML;

                                    var priceParent = elem.item(2);
                                    var price = priceParent.children.item(1).firstChild.firstChild.firstChild.firstChild.firstChild.children.item(1).firstChild.firstChild.innerHTML;

                                    data.push(
                                    {
                                         \"title\": title,
                                         \"price\": price,
                                         \"imageUrl\": imageResult,
                                         \"itemUrl\": itemUrl
                                    }
                                    );
                                } else {

                                    var imageParent = elem.item(0);

                                    var titleParent = elem.item(1);
                                    var title = titleParent.firstChild.firstChild.firstChild.firstChild.innerHTML;
                                    var itemUrl = productSnippets[i].firstChild.children.item(1).href;

                                    var priceParent = elem.item(1);
                                    var price = priceParent.firstChild.firstChild.firstChild.firstChild.innerHTML;

                                    var imageDivs = imageParent.firstChild.firstChild.firstChild.children.item(1);
                                    var imageResult = imageDivs.src;

                                    data.push(
                                    {
                                         \"title\": title,
                                         \"price\": price,
                                         \"imageUrl\": imageResult,
                                         \"itemUrl\": itemUrl
                                     }
                                    );
                                }
                        }
                        return data;
                        ");

        $driver->quit();
        unset($driver);

        return array_map(function ($rawItem) {
            return new ItemDto(
                $rawItem->title,
                $rawItem->itemUrl,
                $rawItem->imageUrl,
                $rawItem->price);
        }, json_decode(json_encode($allProducts)));
    }
}
