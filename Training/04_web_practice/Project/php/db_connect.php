<?php

# Защита от прямого вызова
if (!defined('INCLUDED')) {
    echo "Такого файла не существует.";
    exit;
}

/**
 * Установка соединения с БД.
 * Конфигурация получуется из json файла, путь до которого передается параметром.
 *
 * @param $pathToConfFl
 * @return array|mysqli
 */
function connectToDb($pathToConfFl)
{
    try {
        $dbParams = json_decode(file_get_contents($pathToConfFl));
        $connect = new mysqli($dbParams->host, $dbParams->dbuser, $dbParams->dbpassword, $dbParams->dbname);

        return $connect;
    } catch (BaseException $ex) {
        throw new BaseException(array("error" => 1, msg => "Bad file format or wrong data."));
    }
}