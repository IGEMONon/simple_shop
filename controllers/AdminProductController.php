<?php

class AdminProductController extends AdminBase
{
    /*
     * action для страницы "Управление товарами"
     */
    public function actionIndex()
    {
        //Проверка доступа
        self::checkAdmin();
        //Получаем список товаров
        $productsList = Product::getProductsList();

        //Подключаем вид
        require_once (ROOT .'/views/admin_product/index.php');
        return true;
    }

    /*
     * Action для страницы "добавить товар"
     */
    public function actionCreate()
    {
        //Проверка доступа
        self::checkAdmin();

        //Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();

        if (isset($_POST['submit'])){
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];
            $errors = false;

            if (!isset($options['name']) or empty($options['name'])){
                $errors[] = 'Заполните поля';
            }

            if ($errors == false){
                $id = Product::createProduct($options);
                if (is_uploaded_file($_FILES['image']['tmp_name'])){
                    move_uploaded_file($_FILES["image"]['tmp_name'],
                        $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                }
                header("Location: /admin/product");
            }
        }
        require_once (ROOT . '/views/admin_product/create.php');
        return true;
    }
    /*
     * Action для страницы "Редактировать товар"
     */
    public function actionUpdate($id)
    {
        //Проверка доступа
        self::checkAdmin();
        //Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();

        $product = Product::getProductByID($id);

        if (isset($_POST['submit'])){
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            if (Product::updateProductById($id,$options)){
                if (is_uploaded_file($_FILES['image']['tmp_name'])){
                    move_uploaded_file($_FILES["image"]['tmp_name'],
                        $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                }
            }
            header("Location: /admin/product");
        }
        require_once (ROOT . '/views/admin_product/update.php');
        return true;
    }
    /*
     * Action для страницы "Удалить товар"
     */
    public function actionDelete($id)
    {
        //Проверка доступа
        self::checkAdmin();

        //Обработка формы
        if (isset($_POST['submit'])) {
            Product::deleteProductById($id);

            header("Location: /admin/product");
        }
        require_once (ROOT . '/views/admin_product/delete.php');
        return true;
    }
}