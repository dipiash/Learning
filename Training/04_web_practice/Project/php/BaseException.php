<?php

class BaseException extends Exception{
    private $errorComment;
    private $errorMessage;
    private $errorCode;
    private $errorFile;
    private $errorLine;

    public function __construct($errorComment) {
        $this->errorComment = $errorComment;
        $this->errorMessage = parent::getMessage();
        $this->errorCode = parent::getCode();
        $this->errorFile = parent::getFile();
        $this->errorLine = parent::getLine();
    }

    public function getError() {
        return array("Причина ошибки: {$this->errorComment};",
                     "Сообщение об ошибке: {$this->errorMessage};",
                     "Код ошибки: {$this->errorCode};",
                     "Ошибка в файле: {$this->errorFile}",
                     "Ошибка в строке: {$this->errorLine}");
    }
}