<?php

namespace App\Models\service;

class MarketSignService
{
    private const LOGO_PATH = 'assets/img/market/';

    public static function getLogoByName(string $name): string
    {
        return asset(self::LOGO_PATH . $name . '.png');
    }
}
