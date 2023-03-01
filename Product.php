<?php

// Определяем класс Product
class Product
{
    // Определяем переменные
    public $cost;
    public $remaining_stock;

    // Конструктор
    public function __construct($remaining_stock, $cost)
    {
        $this->cost = $cost;
        $this->remaining_stock = $remaining_stock;
    }

    // Метод для получения себестоимости товара
    public function getCost()
    {
        return $this->cost;
    }
}
?>