<?php

abstract class AdminBase
{
    /**
     * Метод,осуществляющий проверку пользователя на роль администратора
     * @return boolean
     */
    public static function checkAdmin()
    {
        //Проверка на предмет авторизации пользователя
        $userId = User::checkLogged();

        //Получение информации о текущем пользователе
        $user = User::getUserById($userId);

        //Если пользователь имеет статус админ, пускаем его в панель
        if ($user['role'] == 'admin'){
            return true;
        }
        //иначе завершаем работу с сообщением о закрытом доступе
        die('Access denied');
    }
}