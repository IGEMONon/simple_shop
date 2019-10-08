<?php

class Order
{
    /**
     * Сохранение заказа
     * @param $userName
     * @param $userPhone
     * @param $userComment
     * @param $userId
     * @param $products
     * @return bool
     */
    public static function save($userName, $userPhone, $userComment, $userId, $products)
    {
        $nol = null;
        $products = json_encode($products);
//        echo $userName. '<br/>' . $userPhone . '<br/>' . '<br/>' . $userComment. '<br/>' .$userId . '<br/>' . $products;
        $db = Db::getConnection();

        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
                .'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';


        $result = $db->prepare($sql);
        $result->bindParam(':user_name',$userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone',$userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment',$userComment, PDO::PARAM_STR);
        if($userId) {
            $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        }else{
            $result->bindParam(':user_id', $nol, PDO::PARAM_STR);
        }
        $result->bindParam(':products',$products, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function getOrdersListAdmin()
    {
        $db = Db::getConnection();

        $ordersList = array();

        $sql = "SELECT id, user_name, user_phone, user_comment, date, status FROM product_order ORDER BY id ASC";
        $result = $db->query($sql);

        $i = 0;
        while ($row = $result->fetch()){
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['user_comment'] = $row['user_comment'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }
        return $ordersList;
    }
    public static function getStatusText($status)
    {
        switch ($status) {
            case 1:
                return 'Новый';
                break;
            case 2:
                return 'Обрабатывается';
                break;
            case 3:
                return 'Доставляется';
                break;
            case 4:
                return 'Закрыт';
                break;
            }
    }
    public static function getOrderByID($id)
    {
        $id = intval($id);

        if ($id){
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM product_order WHERE id=' . $id);
            $result -> setFetchMode(PDO::FETCH_ASSOC);

            return $result->fetch();
        }
    }
    public static function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status)
    {
        $db = Db::getConnection();

        $sql = "UPDATE product_order
            SET
              user_name = :user_name,
              user_phone = :user_phone,
              user_comment = :user_comment,
              date = :date,
              status = :status
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date',$date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }
    public static function deleteOrderById($id)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM product_order WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
}