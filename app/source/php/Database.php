<?php
namespace Glynet\Database;

use PDO,
    PDOException;

class Database {
    public static array $db;
    public static object $connection;

    public static function connect(array $data)
    {
        self::$db = $data;
        try {
            self::$connection = new PDO("mysql:host={$data['host']};dbname={$data['dbname']};charset=utf8mb4", $data['username'], $data['password']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->exec("set names utf8mb4");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function select(string $where, string $query = null)
    {
        if (!$where || trim($where) == "") return die("Parametreler eksik");
        return self::$connection->query("SELECT * FROM $where " . ($query ? "WHERE $query" : ""));
    }

    public static function insert(string $where, string $data, string $values)
    {
        if (!$where || trim($where) == "") return die("Parametreler eksik");
        return self::$connection->query("INSERT INTO $where ($data) VALUES ($values)");
    }

    public static function delete(string $from, string $query)
    {
        if (!$from || trim($from) == "") return die("Parametreler eksik");
        return self::$connection->query("DELETE FROM $from WHERE $query");
    }

    public static function update(string $from, string $where, string $set)
    {
        if (!$where || trim($where) == "") return die("Parametreler eksik");
        return self::$connection->query("UPDATE $from SET $set WHERE $where");
    }

    public static function fetch($q)
    {
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public static function fetchAll($query)
    {
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getCount($query)
    {
        return $query->rowCount();
    }

    public static function end()
    {
        self::$connection = (object)[];
    }
}