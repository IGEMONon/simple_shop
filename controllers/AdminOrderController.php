<?php

class AdminOrderController extends AdminBase
{
    public function actionIndex()
    {
        //Проверка доступа
        self::checkAdmin();

        $ordersList = Order::getOrdersListAdmin();

        require_once (ROOT . '/views/admin_order/index.php');
        return true;
    }
    public function actionView($id)
    {
        //Проверка доступа
        self::checkAdmin();

        $order = Order::getOrderByID($id);

        $productsQuantity = json_decode($order['products'], true);

        $productsIds = array_keys($productsQuantity);

        $products = Product::getProductsByIds($productsIds);

        require_once (ROOT . '/views/admin_order/view.php');
        return true;
    }
    public function actionUpdate($id)
    {
        //Проверка доступа
        self::checkAdmin();

        $order = Order::getOrderByID($id);

        if (isset($_POST['submit'])){
            $userName = $_POST['user_name'];
            $userPhone = $_POST['user_phone'];
            $userComment = $_POST['user_comment'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            Order::updateOrderById($id, $userName, $userPhone, $userComment, $date, $status);
            header("Location: /admin/order");
        }
        require_once (ROOT . '/views/admin_order/update.php');
        return true;
    }
    public function actionDelete($id)
    {
        //Проверка доступа
        self::checkAdmin();

        if (isset($_POST['submit'])){
            Order::deleteOrderById($id);
            header("Location: /admin/order");
        }
        require_once (ROOT . '/views/admin_order/delete.php');
        return true;
    }
}