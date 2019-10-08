<?php

class AdminController extends AdminBase
{
    public function actionIndex()
    {
        //Проверка доступа
        self::checkAdmin();

        //Подключение вида
        require_once (ROOT . '/views/admin/index.php');
        return true;
    }
}