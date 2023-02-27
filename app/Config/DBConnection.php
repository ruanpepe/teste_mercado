<?php

namespace App\Config;

use PDO, PDOException;

class DBConnection
{
    public $connection;

    /**
     * Retorna a conexão com o banco de dados
     * 
     * @param string $driver
     * @param string $host
     * @param string $port
     * @param string $dbName
     * @param string $user
     * @param string $password
     * @return PDO
     */
    public static function getConnection($driver, $host, $port, $dbName, $user, $password)
    {
        try {
            $DBConnection = new DBConnection();
            $DBConnection->connection = new PDO($driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $dbName, $user, $password);
            $DBConnection->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $DBConnection->connection;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
