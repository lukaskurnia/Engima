<?php
/**
 * Home Page front-end
 * Php version 7.2.19
 *
 * @category front-end
 * @package  components
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Engima | Home</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php
        require_once "includes/redirect.php";
        require_once "includes/helper.php";
        require_once "../db/database.php";
        require_once "navbar.php";
    ?>

    <section id="mainContent" class="wrapper">
        <?php
        $user_id = lookUpId();
        $username = getUsername($user_id);

        $time = time()*1000;
        $time_seven_days_ago = $time - (86400000*7);

        
        $api_key = '2dc9c50e0d06264a13a9e6953b693bba';
        $urlGetData = "https://api.themoviedb.org/3/discover/movie?api_key=" . $api_key .
        "&primary_release_date.gte=" . $time_seven_days_ago . "&primary_release_date.lte=" . $time;
        $get_data = callAPI('GET', $urlGetData, false);
        $movies = json_decode($get_data, true);

        echo "<h1><b>Hello, <span class='blue-text'>{$username}</span>!</b></h1>";

        if (empty($movies)) {
            echo "<h3>No movie playing</h3>";
        } else {
            echo "<h3>Now playing</h3>
                    <div class='hp-content__flex'>";
            foreach ($movies['results'] as $movie) {
                echo "<a href='detail.php?movie_id={$movie['id']}' class='hp-content__element'>
                        <img class='poster--big' src=";
                if ($movie['poster_path'] == null) {
                            echo "../icons/pic.png";
                } else {
                            echo "https://image.tmdb.org/t/p/w500{$movie['poster_path']}";
                }
                        
                        echo " alt='Movie poster'>
                        <div class='content__desc'>
                            <p class='hp-title'>{$movie['title']}</p>
                            <div class='rating'>
                                <img class='small-icon' src='../icons/star.png' alt='star'>";
                                
                if ($movie['vote_average']==null) {
                    echo "<span class='rating__text'>No rating yet</span>";
                } else {
                    $rating = $movie['vote_average'];
                    echo "<span class='rating__text'>{$rating}</span>";
                }
                
                echo        "</div>
                        </div>
                    </a>";
            }
            echo "</div>";
        }
        ?>
    </section>
</body>

</html>