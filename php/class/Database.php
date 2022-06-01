<?php

// класс-обертка поверх PDO, если потребуется его замена в будущем
// класс описывает базовый функционал для работы с БД

class Database extends PDO {

    public $instance;

    function __construct($host, $db, $user, $password, $charset = 'utf8mb4') {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->instance = new PDO($dsn, $user, $password, $options);
    }

    function run($sql, $args = null) {
        $stmt = $this->instance->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    function fetch($sql, $args = null) {
        $stmt = $this->run($sql, $args);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function strgen($alphabet = '0123456789abcdef', $len = 8) {
        $alen = strlen($alphabet) - 1;
        $str = '';
        for($i = 0; $i < $len; $i++) {
            $str .= $alphabet[random_int(0, $alen)];
        }
        return $str;
    }

    function salt() {
        return $this->strgen('0123456789abcdefghijklmnopqrstuvwxyz', 8);
    }

    function pepper() {
        return '11f70g7z';
    }

}

?>