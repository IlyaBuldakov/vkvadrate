<?php

namespace App\Models\dto;

/**
 * DTO для предмета (товара) маркетплейса.
 */
class ItemDto
{

    public string $name;

    public string $itemUrl;

    public string $photoUrl;

    public string $price;

    /**
     * @param string $name
     * @param string $itemUrl
     * @param string $photoUrl
     * @param string $price
     */
    public function __construct(string $name, string $itemUrl, string $photoUrl, string $price)
    {
        $this->name = $name;
        $this->itemUrl = $itemUrl;
        $this->photoUrl = $photoUrl;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItemUrl(): string
    {
        return $this->itemUrl;
    }

    public function getPhotoUrl(): string
    {
        return $this->photoUrl;
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}
