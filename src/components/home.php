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
        $db = new Database("127.0.0.1", "root", "", "enigma");
        $sql_query = "SELECT * FROM movies 
                    LEFT JOIN 
                        (SELECT  movID, AVG(rating) AS rating_avg 
                            FROM rating JOIN 
                            (SELECT orders.id AS ordID,
                            movie_id AS movID,
                            user_id AS userID FROM
                        orders JOIN schedule
                        ON (schedule.id=orders.schedule_id))
                        AS ord ON (rating.orders_id=ord.ordID) GROUP BY movID) 
                    AS rating_table ON (movies.id=rating_table.movID) 
                    WHERE movies.id in (SELECT movie_id FROM schedule 
                        WHERE schedule.datetime>=CURDATE()
                            AND schedule.datetime<CURDATE()+1)";

        $movies=$db->execute($sql_query, array(), array());

        echo "<h1><b>Hello, <span class='blue-text'>{$username}</span>!</b></h1>";

        if (empty($movies)) {
            echo "<h3>No movie playing</h3>";
        } else {
            echo "<h3>Now playing</h3>
                    <div class='hp-content__flex'>";
            foreach ($movies as $movie) {
                echo "<a href='detail.php?movie_id={$movie['id']}' class='hp-content__element'>
                        <img class='poster--big' src='{$movie['movie_pictures']}' alt='Movie poster'>
                        <div class='content__desc'>
                            <p class='hp-title'>{$movie['movie_name']}</p>
                            <div class='rating'>
                                <img class='small-icon' src='../icons/star.png' alt='star'>";
                                
                if ($movie['rating_avg']==null) {
                    echo "<span class='rating__text'>No rating yet</span>";
                } else {
                    $rating = number_format($movie['rating_avg'] + 0, 2, ".", "");
                    $rating = rtrim(rtrim($rating, "0"), ".");
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