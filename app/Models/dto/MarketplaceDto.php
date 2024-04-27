<?php

namespace App\Models\dto;

/**
 * DTO маркетплейса.
 * Информация о маркетплейсе, которая должна находится на представлении.
 */
class MarketplaceDto
{
    public string $logoPath;

    public array $items;

    public string $sign;

    public function __construct(string $logoPath, array $items, string $sign)
    {
        $this->logoPath = $logoPath;
        $this->items = $items;
        $this->sign = $sign;
    }

    public function __toString(): string
    {
        return json_encode($this);
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
