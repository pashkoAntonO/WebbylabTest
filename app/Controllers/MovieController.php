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
                array_push($stars, htmlspecialchars($star, ENT_QUOTES, "UTF-8"));
            }
        }
        $title = htmlspecialchars($_POST["title"], ENT_QUOTES, "UTF-8");

        Movie::insert($title, (int)$_POST["year"], $_POST["format"], $stars);
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
                array_push($stars, htmlspecialchars($star, ENT_QUOTES, "UTF-8"));
            }
        }
        $title = htmlspecialchars($_POST["title"], ENT_QUOTES, "UTF-8");
        Movie::edit($id, $title, (int)$_POST["year"], $_POST["format"], $stars);
        header("Location: /");
    }

    /**
     * Поиск названия
     *
     * @param0
     */
    public function searchTitleAction()
    {
        $searchTitle = htmlspecialchars($_POST["searchTitle"], ENT_QUOTES, "UTF-8");
        $movies = Movie::findFields($searchTitle, 'title');

        return View::view('index', $movies);
    }

    /**
     * Поиск актера
     *
     * @param
     */
    public function searchNameAction()
    {

        $searchStars = htmlspecialchars($_POST["searchStars"], ENT_QUOTES, "UTF-8");
        $movies = Movie::findFields($searchStars, 'stars');

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
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        setlocale(LC_ALL, 'ukr_uk');

        uasort($movies, 'self::sort');

        return View::view('index', $movies);
    }

    private function sort($a, $b)
    {
        $a = mb_strtoupper($a['title'], 'UTF-8');
        $b = mb_strtoupper($b['title'], 'UTF-8');

        $alphabet = array(
            'А' => 1, 'Б' => 2, 'В' => 3, 'Г' => 4, 'Д' => 5, 'Е' => 6, 'Є' => 7, 'Ж' => 8, 'З' => 9, 'И' => 10, 'І' => 11,
            'Ї' => 12, 'Й' => 13, 'К' => 14, 'Л' => 15, 'М' => 16, 'Н' => 17, 'О' => 18, 'П' => 19, 'Р' => 20, 'С' => 21, 'Т' => 22,
            'У' => 23, 'Ф' => 24, 'Х' => 25, 'Ц' => 26, 'Ч' => 27, 'Ш' => 28, 'Щ' => 29, 'Ь' => 30, 'Ю' => 31, 'Я' => 32
        );
        $lengthA = mb_strlen($a, 'UTF-8');
        $lengthB = mb_strlen($b, 'UTF-8');
        for ($i = 0; $i < ($lengthA > $lengthB ? $lengthB : $lengthA); $i++) {
            if (isset($alphabet[mb_substr($a, $i, 1, 'UTF-8')]) && isset($alphabet[mb_substr($b, $i, 1, 'UTF-8')])) {

                if ($alphabet[mb_substr($a, $i, 1, 'UTF-8')] < $alphabet[mb_substr($b, $i, 1, 'UTF-8')]) {
                    return -1;
                    break;
                } elseif ($alphabet[mb_substr($a, $i, 1, 'UTF-8')] > $alphabet[mb_substr($b, $i, 1, 'UTF-8')]) {
                    return 1;

            }
            } else {
                return strnatcasecmp($a, $b);
            }
        }
    }

        /**
         * Загрузка и считывание файла
         *
         * @param
         */
        public
        function uploadAction()
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
                                $value = explode(", ", htmlspecialchars($value, ENT_QUOTES, "UTF-8"));
                            }

                            $movieArr[$key] = $value;
                        }

                        if (count($movieArr) == 4) {

                            $title = htmlspecialchars($movieArr["title"], ENT_QUOTES, "UTF-8");
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