<?php

namespace app\Models;

use core\Database;

class Movie
{
    /**
     * Добавление в бд
     *
     * @param string $title , int $year, string $format, array $stars
     *
     * @return void
     *
     */
    public static function insert(string $title, int $year, string $format, array $stars): void
    {

        $db = new Database();
        $db = $db->getDb();
        $stars = implode(', ', $stars);
        $sql = "INSERT INTO movies (`title`, `year`, `format`, `stars`) VALUES ('$title', '$year', '$format', '$stars')";

        $sth = $db->prepare($sql);
        $sth->execute();
    }

    /**
     * Вывод все фильмов
     *
     * @param
     *
     * @return array
     *
     */
    public static function allFind(): array
    {
        $db = new Database();
        $db = $db->getDb();
        $sql = "SELECT * FROM movies";

        $sth = $db->prepare($sql);
        $sth->execute();
        $allMovies = $sth->fetchAll();

        return $allMovies;

    }

    /**
     * Удаление поля
     *
     * @param int $id
     *
     * @return void
     *
     */
    public static function delete(int $id): void
    {
        $db = new Database();
        $db = $db->getDb();
        $sql = "DELETE FROM `movies` WHERE `id` = '$id' ";
        $sth = $db->prepare($sql);
        $sth->execute();
    }

    /**
     * Нахождение фильма
     *
     * @param int $id
     *
     * @return array
     *
     */
    public static function findOne(int $id): array
    {
        $db = new Database();
        $db = $db->getDb();
        $sql = "SELECT * FROM movies WHERE `id` = '$id' LIMIT 1";
        $sth = $db->prepare($sql);
        $sth->execute();

        return $sth->fetch();
    }

    /**
     * Поиск фильмов
     *
     * @param string $word ,string $field
     *
     * @return array
     *
     */
    public static function findFields(string $word, string $field): array
    {

        $db = new Database();
        $db = $db->getDb();
        $sql = "SELECT * FROM movies WHERE `$field` LIKE '%$word%' ";
        $sth = $db->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();

    }

    /**
     * Редактирование фильма
     *
     * @param int $id , string $title, int $year, string $format, array $stars
     *
     * @return void
     *
     */
    public static function edit(int $id, string $title, int $year, string $format, array $stars): void
    {
        $db = new Database();
        $db = $db->getDb();
        $stars = implode(', ', $stars);
        $sql = "UPDATE `movies` SET `id`='$id',`title`='$title',`year`='$year',`format`='$format',`stars`='$stars' WHERE `id` = '$id'";
        $sth = $db->prepare($sql);
        $sth->execute();

    }

}