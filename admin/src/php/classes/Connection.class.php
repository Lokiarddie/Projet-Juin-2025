<?php
class Connection
{
    private static $_db = null;

    public static function getInstance($dsn, $username, $password)
    {
        try {
            self::$_db = new PDO($dsn, $username, $password);
            //print "connected";
        } catch (PDOException $e) {
            print "Connection error: " . $e->getMessage();
        }

        return self::$_db;
    }
}

