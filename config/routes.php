<?php

return [
    //Путь к контролеру и методу с параметрами
    '/' => 'MovieController@indexAction',
    'upload' => 'MovieController@uploadAction',
    'create' => 'MovieController@createAction',
    'add' => 'MovieController@addAction',
    'edit/([0-9]+)' => 'MovieController@editAction/$1',
    'update/([0-9]+)' => 'MovieController@updateAction/$1',
    'searchTitle' => 'MovieController@searchTitleAction',
    'searchStars' => 'MovieController@searchNameAction',
    'delete/([0-9]+)' => 'MovieController@deleteAction/$1',
    'sort' => 'MovieController@sortAction',

];