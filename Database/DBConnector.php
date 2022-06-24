<?php

namespace Database;

use PDO;

class DBConnector
{

    public static function create(): PDODatabase
    {
        $file = "Config/db.ini";
        $dbInfo = parse_ini_file($file);

        $pdo = new PDO($dbInfo['dsn'],$dbInfo['user'],$dbInfo['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return new PDODatabase($pdo);
    }
}