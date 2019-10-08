<?php

/*
 * Класс для генерации постраничной навигации
 */

class Pagination
{
    private $max = 10; //Количество ссылок навигации
    private $index = 'page-'; //Ключ для _GET с номером страницы
    private $current_page; //Номер текущей страницы
    private $total; //Общее количество записей
    private $limit; //Количество записей на одну страницу
    private $amount; //Количество страниц

    /**
     * Запуск необходимых данных для навигации
     * @param integer $total - общее количество записей
     * @param integer $limit - количество записей на страницу
     *
     * @return
     */
    public function __construct($total, $currentPage, $limit, $index)
    {
        $this->total = $total; //Общее количество записей
        $this->limit = $limit; //Количество записей на страницу
        $this->index = $index;//Ключ в url
        $this->amount = $this->amount();//Количество страниц
        $this->setCurrentPage($currentPage);//Номер текущей страницы
    }

    /**
     *  Для вывода ссылок
     *
     * return HTML-код со ссылками навигации
     */
    public function get()
    {
        $links = null;//Для записи ссылок
        $limits = $this->limits();//Ограничения для цикла
        $html = '<ul class="pagination">';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {//Генерация ссылок
            if ($page == $this->current_page) {//Если это текущая страница - ссылки нет и добавляется класс active
                $links .= '<li class="active"><a href="#">' . $page . '</a></li>';
            } else {
                $links .= $this->generateHtml($page);//Иначе генерируется ссылка
            }
        }
        if (!is_null($links)) {//Если ссылки созданы
            if ($this->current_page > 1) {//Если текущая страница не первая
                $links = $this->generateHtml(1, '&lt;') . $links;//Создаётся ссылка "На первую"
            }
            if ($this->current_page < $this->amount) {//Если текущая страница не последняя
                $links .= $this->generateHtml($this->amount, '&gt;');//Создаётся ссылка "На последнюю"
            }
        }

        $html .= $links . '</ul>';
        return $html;//Возвращаем код <ul>...<li></li>...</ul>
    }

    /**
     * Для генерации HTML-кода ссылки
     * param integer $page - номер страницы
     *
     * return
     */
    private function generateHtml($page, $text = null) //Генерация HTML кода ссылки
    {
        if (!$text){//Если текст ссылки не указан
            $text = $page;//Текст - номер страницы
        }
        $currentURI = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $currentURI = preg_replace('~/page-[0-9]+~', '', $currentURI);
        # Формируем HTML код ссылки и возвращаем
        return
            '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
    }
    private function limits() //Массив с началом и концом отсчёта
    {
        $left = $this->current_page - round($this->max / 2);//Номер ссылки слева (чтобы активная была по центру)
        $start = $left > 0 ? $left : 1;//Корректировка начала отсчёта
        if ($start + $this->max <= $this->amount) { //Если впереди есть $this->max страниц
            $end = $start > 1 ? $start + $this->max : $this->max;//Конец цикла вперёд на $this->max страниц
        } else {
            $end = $this->amount;//Конец - общее количество страниц
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;//Начало - минус $this->max от конца или 1
        }
        return array($start, $end);
    }
    private function setCurrentPage($currentPage) //Корректировка текущей страницы
    {
        $this->current_page = $currentPage;//Получаем номер страницы
        if ($this->current_page > 0) { //Если номер текущей страницы больше нуля
            if ($this->current_page > $this->amount) { //Если номер текущей страницы больше общего количества страниц
                $this->current_page = $this->amount; //Устанавливаем текущую страницу последней
            }
        }else $this->current_page = 1; //Иначе (Если меньше 0) устанавливаем текущую страницу первой
    }
    private function amount() //Определяет общее число страниц
    {
        return round($this->total / $this->limit); //Общее количество записей / на количество записей на страницу
    }

}
