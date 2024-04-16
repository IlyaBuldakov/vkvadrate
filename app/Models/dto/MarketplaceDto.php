<?php

namespace App\Models\dto;

class MarketplaceDto
{
    private string $logoPath;

    private array $items;

    public function __construct(string $logoPath, array $items,)
    {
        $this->logoPath = $logoPath;
        $this->items = $items;
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
}
