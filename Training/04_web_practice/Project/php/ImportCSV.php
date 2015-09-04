<?php

if (!defined('INCLUDED')) {
    echo "Такого файла не существует.";
    exit;
}

class ImportCSV
{
    /**
     * Импортирование данных.
     *
     * @param $data
     * @return string
     */
    public function importData($data) {
        $countAdd = 0; # кол-во добавленные записей
        $countUpdate = 0; # кол-во обновленных записей

        $db = connectToDb('config/db.json');

        try {
            if ($stmt_checkData = $db->prepare('SELECT `name`
                                        FROM `product`
                                        WHERE
                                          `id` = ? AND
                                          `user_id` = ?')) {

                $countData = count($data);
                $i = 0;

                while ($i != $countData) {
                    $stmt_checkData->bind_param('ii', $data[$i]['id'], $data[$i]['user_id']);

                    if (!$stmt_checkData->execute()) {
                        throw new Exception;
                    }

                    $result = $stmt_checkData->get_result()->fetch_array();

                    if (isset($result['name'])) { # если запись существует, то обновляем
                        $this->updateData($db, $data[$i]);
                        $countUpdate++;
                    } else { # иначе вставляем новые данные
                        $this->insertData($db, $data[$i]);
                        $countAdd++;
                    }

                    ++$i;
                }

                $db->close();

                return json_encode(array("add" => $countAdd, "update" => $countUpdate));
            } else {
                throw new BaseException("Ошибка в подготовленном запросе.");
            }

        } catch (BaseException $ex) {
            return FALSE;
        }
    }

    /**
     * Метод вставки данных в БД.
     * На вход подаются:
     *      коннект с БД
     *      данные
     *
     * @param $db
     * @param $data
     * @return bool
     * @throws Exception
     */
    private function insertData($db, $data)
    {
        try {
            if ($stmt_insData = $db->prepare("INSERT INTO `product` VALUES (?, ?, ?, ?, ?, ?, ?)")) {
                $stmt_insData->bind_param('issdssi', $data['id'],
                    $data['name'],
                    $data['name_trans'],
                    $data['price'],
                    $data['small_text'],
                    $data['big_text'],
                    $data['user_id']);

                if (!$stmt_insData->execute()) {
                    throw new BaseException("Не удалось выполнить запрос.");
                }

                return TRUE;
            } else {
                throw new BaseException("Ошибка в подготовленном запросе.");
            }

        } catch (BaseException $ex) {
            return FALSE;
        }
    }

    /**
     * Метод обновления данных.
     * На вход подаются:
     *      коннект с БД
     *      данные
     *
     * @param $db
     * @param $data
     * @return bool
     */
    private function updateData($db, $data)
    {
        try {
            if ($stmt_insData = $db->prepare("UPDATE `product`
                                          SET
                                            `name` = ?,
                                            `name_trans` = ?,
                                            `price` = ?,
                                            `small_text` = ?,
                                            `big_text` = ?
                                          WHERE
                                            `id` = ? AND
                                            `user_id` = ?")
            ) {

                $stmt_insData->bind_param('ssdssii', $data['name'],
                                                     $data['name_trans'],
                                                     $data['price'],
                                                     $data['small_text'],
                                                     $data['big_text'],
                                                     $data['id'],
                                                     $data['user_id']);

                if (!$stmt_insData->execute()) {
                    throw new BaseException("Не удалось выполнить запррос.");
                }

                return TRUE;
            } else {
                throw new BaseException("Ошибка в подготовленном запросе.");
            }

        } catch (BaseException $ex) {
            return FALSE;
        }
    }
}
