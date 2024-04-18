<?php

namespace App\Models\dto;

class MarketplaceDto
{
    private string $logoPath;

    private array $items;

    private string $sign;

    public function __construct(string $logoPath, array $items, string $sign)
    {
        $this->logoPath = $logoPath;
        $this->items = $items;
        $this->sign = $sign;
    }

    /**
     * @return string
     */
    public function getLogoPath(): string
    {
        return $this->logoPath;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getSign(): string
    {
        return $this->sign;
    }
}
