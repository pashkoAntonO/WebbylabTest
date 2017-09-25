<?php

namespace app\Controller;

use app\Models\Movie;
use core\Router;
use core\View;


class MovieController
{
    /**
     * Вывод главной страницы, с выводом всех элементов из бд
     */
    public function indexAction()
    {
        $movies = Movie::allFind();


        return View::view('index', $movies);
    }

    /**
     * Добавление нового фильма
     */
    public function addAction()
    {
        $_SESSION["create"] = "true";
        $stars = array();
        foreach ($_POST["stars"] as $star) {
            if (!empty($star)) {
                array_push($stars, $star);
            }
        }
        Movie::insert($_POST["title"], (int)$_POST["year"], $_POST["format"], $stars);
        header("Location: /");

    }

    /**
     * Переход на страницу создания нового фильма
     *
     */
    public function createAction()
    {
        return View::view('create');
    }


    public function deleteAction($id)
    {
        Movie::delete($id);

        header("Location: /");
    }

    /**
     * Возвращает страницу с редактированием
     *
     * @param int $id
     */
    public function editAction(int $id)
    {
        $movie = Movie::findOne($id);

        $movie["stars"] = explode(', ', $movie["stars"]);

        return View::view('edit', $movie);
    }

    /**
     * Обновление поля
     *
     * @param int $id
     */
    public function updateAction(int $id)
    {
        $_SESSION["edit"] = "true";
        $stars = array();
        foreach ($_POST["stars"] as $star) {
            if (!empty($star)) {
                array_push($stars, $star);
            }
        }
        Movie::edit($id, $_POST["title"], (int)$_POST["year"], $_POST["format"], $stars);
        header("Location: /");
    }

    /**
     * Поиск названия
     *
     * @param
     */
    public function searchTitleAction()
    {
        $movies = Movie::findFields($_POST["searchTitle"], 'title');

        return View::view('index', $movies);
    }

    /**
     * Поиск актера
     *
     * @param
     */
    public function searchNameAction()
    {
        $movies = Movie::findFields($_POST["searchStars"], 'stars');

        return View::view('index', $movies);
    }

    /**
     * Сортировка
     *
     * @param
     */
    public function sortAction()
    {
        $movies = Movie::allFind();

        uasort($movies, function ($a, $b) {
            return strnatcasecmp($a['title'], $b['title']);
        });


        return View::view('index', $movies);
    }

    /**
     * Загрузка и считывание файла
     *
     * @param
     */
    public function uploadAction()
    {
        if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {

            $fileName = $_FILES['filename']['name'];
            $splitName = explode('.', $fileName);
            $fileType = $splitName[count($splitName) - 1];

            if ($fileType == 'txt' && $_FILES['filename']['size'] != 0) {

                $text = file_get_contents($_FILES["filename"]["tmp_name"], true);
                $movies = explode("\n\n", trim($text));

                foreach ($movies as $movie) {
                    $fields = explode("\n", $movie);

                    if (count($fields) != 4) {
                        return View::error("Фильм не содержит необходимые поля");
                    }

                    $title = explode(':', $fields[0]);

                    foreach ($fields as $field) {
                        list($key, $value) = explode(": ", $field);
                        $key = str_replace(' ', '_', strtolower($key));
                        if ($key == 'stars') {
                            $value = explode(", ", $value);
                        }

                        $movieArr[$key] = $value;
                    }

                    if (count($movieArr) == 4) {

                        $title = $movieArr["title"];
                        $year = (int)$movieArr["release_year"];
                        $format = trim($movieArr["format"]);
                        $stars = $movieArr["stars"];

                        Movie::insert($title, $year, $format, $stars);
                    }
                }
            } else {
                return View::error("Файлы типа $fileType не поддерживаются");
            }

        }

        header("Location: /");

    }

}