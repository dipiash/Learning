<?php

if (!defined('INCLUDED')) {
    echo "Такого файла не существует.";
    exit;
}

# Автозагрузка классов
function __autoload($class_name) {
    include $class_name . '.php';
}

# Библиотека для безопасной загрузки файлов
# https://github.com/brandonsavage/Upload

$storage = new \Upload\Storage\FileSystem('upload/');
$file = new \Upload\File('file', $storage);

$new_filename = uniqid();
$file->setName($new_filename);

# ограничения для загружаемых файлов
$file->addValidations(array(
    new \Upload\Validation\Mimetype('text/plain'),
    new \Upload\Validation\Extension('csv'),
    new \Upload\Validation\Size('15M')
));

try {
    # файд успешно загружен
    $file->upload();
} catch (\Exception $e) {
    $errors = $file->getErrors();

    echo json_encode(array("error" => $errors));
}