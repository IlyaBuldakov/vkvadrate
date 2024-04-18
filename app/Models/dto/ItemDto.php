<?php

namespace App\Models\dto;

/**
 * DTO для предмета (товара) маркетплейса.
 */
class ItemDto
{

    private string $name;

    private string $itemUrl;

    private string $photoUrl;

    private int $price;

    /**
     * @param string $name
     * @param string $itemUrl
     * @param string $photoUrl
     * @param int $price
     */
    public function __construct(string $name, string $itemUrl, string $photoUrl, int $price)
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

    public function getPrice(): int
    {
        return $this->price;
    }
}