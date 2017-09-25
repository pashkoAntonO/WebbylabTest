<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 24.09.2017
 * Time: 1:27
 */

namespace core;


class Database
{
    private $db;

    public function __construct()
    {
        $paramsPath = ROOT . '/config/db.php';

        $params = include($paramsPath);


        $this->db = new \PDO('mysql:host=' . $params['host'], $params['user'], $params['password']);
        $sql = "CREATE DATABASE IF NOT EXISTS ". $params["dbname"];
        $this->db->exec($sql);
        $sql = NULL;
        $this->db = new \PDO('mysql:host=' . $params['host'] . ';dbname=' . $params["dbname"], $params['user'], $params['password']);
        $this->db->exec("set names utf8");

        $sql = "CREATE TABLE IF NOT EXISTS `movies` ( `id` INT AUTO_INCREMENT, `title` CHAR(255), `year` int, `format` char(10), `stars` text, PRIMARY KEY(`id`), UNIQUE(`title`) )";
        $sth = $this->db->prepare($sql);
        $sth->execute();

    }

    public function getDb()
    {
        return $this->db;
    }


}