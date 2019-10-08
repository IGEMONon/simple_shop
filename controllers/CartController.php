<?php

class CartController
{
    public function actionAdd($id)
    {
        //Добавляем товар в корзину
        Cart::addProduct($id);

        //Возвращаем пользователя на страницу
        $referrer = $_SERVER['HTTP_REFERER']; //Узнаем адрес страницы с которой пришел пользователь
        header("Location: $referrer");
    }
    public function actionAddAjax($id)
    {
        //Добавляем товар в корзину
        echo Cart::addProduct($id);
        return true;
    }
    public function actionDelete($productId)
    {
        //Удаление товара
        Cart::deleteProduct($productId);
        header("Location: /cart/");
    }
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $productsInCart = false;

        //Получим данные из корзины
        $productsInCart = Cart::getProducts(); //Массив идентификаторы и количество

        if ($productsInCart) {//Если товары есть
            //Получаем полную информацию о товарах для списка
            $productsIds = array_keys($productsInCart); //Получаем идентификаторы
            $products = Product::getProductsByIds($productsIds);
            //Получаем общую стоимость товаров
            $totalPrice = Cart::getTotalPrice($products);
        }
        require_once (ROOT . '/views/cart/index.php');
        return true;
    }

    public function actionCheckout()
    {
        //Список категорий для левого меню
        $categories = array();
        $categories = Category::getCategoriesList();

        //Статус успешного оформления заказа
        $result = false;

        if (isset($_POST['submit'])){ //Форма отправлена
            //Считываем данные формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            //Валидация полей
            $errors = false;
            if (!User::checkName($userName)){
                $errors[] = 'Неправильное имя';
            }
            if (!User::checkPhone($userPhone)){
                $errors[] = 'Неправильный телефон';
            }

            if ($errors == false) { //Форма заполнена корректно
                //Сохраняем заказ в базе данных
                //Собираем информацию о заказе

                $productsInCart = Cart::getProducts();
                if (User::isGuest()){
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }

                //Сохраняем заказ в базе данных
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    $adminEmail = 'zozo997@mail.ru';
                    $message = 'Shop/admin/orders';
                    $subject = 'Новый заказ';
                    mail($adminEmail,$subject, $message);
                    //Очистка корзины
                    Cart::clear();
                }
            }else{
                //Форма заполнена некорректно
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        }else{
            //форма не отправлена
            $productsInCart = Cart::getProducts();
            if ($productsInCart == false){//Если в корзине нет товаров
                header("Location: /");//Отправляем на главную
            } else { //В корзине есть товары
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();

                $userName = false;
                $userPhone = false;
                $userComment = false;

                if (User::isGuest()){
                    //Если пользователь не авторизован, то поля пустые
                }else{
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    $userName = $user['name']; //подставление в форму
                }
            }
        }
        require_once (ROOT . '/views/cart/checkout.php');
        return true;
    }
}