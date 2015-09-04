<?php

header('Content-Type: text/html; charset=utf-8');

define('INCLUDED', 1); # для защиты файлов от прямого вызова

# разбираем url
$req = urldecode(trim($_SERVER["REQUEST_URI"], '/'));
$parts = array_filter(explode('/', $req));

require_once('php/db_connect.php');
require_once('php/BaseException.php');

# определяем действия
switch ($parts[0]) {
    case '': # показать главную страницу
        require_once('index.html');
        break;

    case 'uplcsv': # загрузка файла на сервер

        require_once('php/uploud_csv.php');
        require_once('php/parse_csv.php');
        require_once('php/ImportCSV.php');

        $data = parseCsv('upload/'.$new_filename.'.csv'); # получем данные из загруженного csv файла

        $prepare = new ImportCSV();

        echo $prepare->importData($data); # импортируем данные в БД и возвращаем ответ

        break;
}
