<?php

namespace App\Models\service\market;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Firefox\FirefoxDriver;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use GuzzleHttp\Client;

class YandexMarketService extends MarketplaceService
{

    const SEARCH_PATH = "https://market.yandex.ru/search-redirect";

    private const XPATH_TITLE_QUERY = './/*[@data-auto=\'snippet-title\']';

    private const XPATH_PRICE_QUERY = './/*[@data-auto=\'snippet-price-current\']';

    private const XPATH_IMAGE_QUERY = './/*[@data-zone-name=picture\'\']';

    private const FIREFOX_SERVER_URL = 'http://localhost:4444';

    private const FIREFOX_SERVER_EXE = 'C:\geckodriver.exe';

    private const FIREFOX_EXE_URL = 'C:\Program Files\Mozilla Firefox\firefox.exe';

    protected function getSign(): string
    {
        return 'yandexmarket';
    }

    public function search(string $query): array
    {
        $desiredCapabilities = DesiredCapabilities::firefox();
        $desiredCapabilities->setCapability('acceptSslCerts', false);

        $firefoxOptions = new FirefoxOptions();
        $firefoxOptions->addArguments(['-headless']);
        $firefoxOptions->setOption('binary', self::FIREFOX_EXE_URL);

        $desiredCapabilities->setCapability(FirefoxOptions::CAPABILITY, $firefoxOptions);

        putenv('WEBDRIVER_FIREFOX_DRIVER=' . self::FIREFOX_SERVER_EXE);

        $driver = RemoteWebDriver::create(self::FIREFOX_SERVER_URL, $desiredCapabilities);
        $driver->get(self::SEARCH_PATH . "?text=$query");

        $titles = $driver->findElements(WebDriverBy::xpath(self::XPATH_TITLE_QUERY));
        $prices = $driver->findElements(WebDriverBy::xpath(self::XPATH_PRICE_QUERY));
        $image = $driver->findElements(WebDriverBy::xpath(self::XPATH_IMAGE_QUERY));

        $driver->quit();
        return [];
    }
}

//$client = new Client(
//    ['verify' => false]
//);
//$response = $client->get(self::SEARCH_PATH . "?text=$query");
//$html = $response->getBody();
//$html = str_replace('/captcha_smart', 'https://yandex.ru/captcha_smart', $html);
//
//$html = str_replace('crossorigin', '', $html);
//echo $html;
////$domModel = HtmlDomParser::file_get_html();
////dd($domModel);
//// ->find('div[data-auto=snippet-title]')
//return [];
