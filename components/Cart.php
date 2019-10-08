<?php

class Cart
{
    public static function addProduct($id)
    {
        $id = intval($id);

        $productsInCart = array(); //Пустой массив товаров в корзине

        //Если в массиве уже есть товары (хранятся в сессии)
        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products']; //Заполняем массив товарами
        }

        //Если товар есть в корзине и был добавлен ещё раз - увеличиваем количество
        if (array_key_exists($id,$productsInCart)) {
            $productsInCart[$id] ++;
        }else{
            //Добавляем новый товар в корзину
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }

    /**
     * Подсчёт количества товаров в корзине (в сессии)
     * @return int
     */
    public static function countItems()
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        }else{
            return 0;
        }
    }

    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }
    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        $total = 0;

        if ($productsInCart) {
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }
    public static function deleteProduct($id)
    {
        $productsInCart = $_SESSION['products'];
        if ($productsInCart){
            unset($productsInCart[$id]);
            $_SESSION['products'] = $productsInCart;
        }
    }
    public static function Clear()
    {
        if (isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }
}