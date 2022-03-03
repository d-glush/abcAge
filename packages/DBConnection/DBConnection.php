<?php

namespace DBConnection;

use PDO;

class DBConnection
{
    private PDO $connection;

    public function __construct($host, $database, $user, $password)
    {
        $dsn = "mysql:host=$host;dbname=$database";
        $this->connection = new PDO($dsn, $user, $password);
    }

    public function query($queryText): bool|\PDOStatement
    {
        return $this->connection->query($queryText);
    }

    public function execute($queryText): bool|int
    {
        return $this->connection->exec($queryText);
    }

}