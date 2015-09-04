<?php

# Защита от прямого вызова
if (!defined('INCLUDED')) {
    echo "Такого файла не существует.";
    exit;
}

/**
 * Функция парсинга CSV файла.
 * На вход передается путь до файла.
 *
 * @param $pathToFl
 * @return array
 */
function parseCsv($pathToFl) {
    $resultParse = [];

    $handle = fopen($pathToFl, "r");
    if ($handle !== FALSE) {
        while (($data = fgetcsv($handle, 100000, ';')) !== FALSE) {

            # если поле small_text пустое, то берем 30 символов от поля big_text
            if (strlen(trim($data[4])) == 0) {
                $data[4] = strip_tags(substr($data[5], 0, 30));
            }

            $resultParse[] = ["id" => $data[0],
                              "name" => $data[1],
                              "name_trans" => $data[2],
                              "price" => $data[3],
                              "small_text" => $data[4],
                              "big_text" => $data[5],
                              "user_id" => $data[6]
                             ];
        }
        fclose($handle);

        return $resultParse;
    } else {
        echo array("error" => 1, "msg" => "Error parse file.");
    }
}