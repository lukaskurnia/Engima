<?php

require_once '../components/includes/helper.php';

if (isset($_GET["query"]) && isset($_GET["page"])) {
    $api_key = '2dc9c50e0d06264a13a9e6953b693bba';
    $query = "{$_GET["query"]}";
    $page = "{$_GET["page"]}";
    $urlGetData = "https://api.themoviedb.org/3/search/movie?api_key=" . $api_key .
    "&query=" . $query . "&page=" . $page;
    $get_data = callAPI('GET', $urlGetData, false);
    echo $get_data;
}
