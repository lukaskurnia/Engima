<?php
/**
 * Detail Page front-end
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
    <title>Engima | Detail</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php
        use engima\Database;
        
        require_once "includes/redirect.php";
        require_once "navbar.php";
    ?>


    <div class="wrapper">
        <?php
        
        require_once "../db/database.php";
        
        $movie_id = (int)$_GET["movie_id"];

        $api_key = '2dc9c50e0d06264a13a9e6953b693bba';
        $urlGetData = "https://api.themoviedb.org/3/movie/" . $movie_id .
        "?api_key=" . $api_key;
        $get_data = callAPI('GET', $urlGetData, false);
        $movie_data = json_decode($get_data, true);


        // $movie_id = (int)$_GET["movie_id"];
        $db = new engima\Database("127.0.0.1", "root", "", "enigma");
        // $sql_query = "SELECT * FROM movies WHERE movies.id=?";
        // $movie_data=$db->execute($sql_query, array("i"), array($movie_id))[0];
        // $release_date = strtotime($movie_data['released_date']);
        // $release_date = date('F j, Y', $release_date);
        

        $sql_query = "SELECT * FROM schedule WHERE 
                    schedule.movie_id=? AND schedule.datetime>=CURDATE()";
        $db->execute($sql_query, array("i"), array($movie_id));
        
        $sql_query = "SELECT userID,rating,review, movID 
                    FROM rating JOIN 
                        (SELECT orders.id AS ordID,
                            movie_id AS movID,
                            user_id AS userID FROM
                                orders JOIN schedule
                                    ON (schedule.id=orders.schedule_id))
                        AS ord ON (rating.orders_id=ord.ordID) WHERE movID=?";
        $reviews=$db->execute($sql_query, array("i"), array($movie_id));
        

        $rating=0;
        foreach ($reviews as $review) {
            $rating+=$review['rating'];
        }

        if ($rating==0) {
            $rating = "<b>No rating yet</b>";
        } else {
            $rating = number_format($rating/count($reviews) + 0, 2, ".", "");
            $rating = rtrim(rtrim($rating, "0"), ".");
            $rating = "<b>{$rating}</b> / 10";
        }

        foreach ($movie_data['genres'] as $movie) {
            $genre = $genre . "{$movie['name']}, ";
        }



        echo "<section class='movie'>
            <div class='dp-movie__summary'>
                <div class='dp-movie__poster'>
                    <img class='poster--big' 
                    src=https://image.tmdb.org/t/p/w500{$movie_data['poster_path']} 
                    alt='Movie poster'>
                </div>
                <div class='dp-movie__text'>
                    <h2 class='dp-movie__title'>{$movie_data['title']}</h2>
                    <div class='dp-movie__subtext blue-text'>";
                    echo substr($genre, 0, -2);
                    echo " | {$movie_data['runtime']} mins
                    </div>
                    <div class='dp-movie__subtext grey-text'>
                        Released date: {$movie_data['release_date']}
                    </div>
                    <div class='rating'>
                        <img class='big-icon' src='../icons/star.png' alt='star'>
                        <span class='dp-rating'>
                            {$rating}
                        </span>
                    </div>
                    <div class='rating'>
                        <img class='big-icon' src='../icons/mdbicon.png' alt='mdbicon'>
                        <span class='dp-rating'>
                            MovieDB Rating: {$movie_data['vote_average']}
                        </span>
                    </div>
                    <p class='dp-movie__subtext 
                    dp-movie__subtext--light'>
                        {$movie_data['overview']}
                    </p>
                </div>
            </div>
        </section>

        <div class='dp-grid-container'>
            <section class='dp-schedule'>
                <h3>Schedules</h3>";
        if (empty($schedules)) {
            echo '<p class="dp-empty-text">No schedule available</p>';
        } else {
            echo '<table cellpadding="10px">
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Available Seats</th>
                </tr>';
                    
            foreach ($schedules as $schedule) {
                $datetime = strtotime($schedule['datetime']);
                $date = date('F j, Y', $datetime);
                $time = date('h:i A', $datetime);
                        
                $sql_query = "SELECT COUNT(id) 
                            FROM orders 
                            where orders.schedule_id=?";
                $params_type = array("i");
                $params_values = array($schedule['id']);
                $sql_result = $db->execute($sql_query, $params_type, $params_values);
                $seat_left = 30-$sql_result[0]['COUNT(id)'];

                echo "<tr>
                        <td>{$date}</td>
                        <td>{$time}</td>
                        <td>
                            <div class='dp-schedule__flex'>
                                <div class='black-text'>
                                    {$seat_left}
                                </div>";

                if ($seat_left>0) {
                    echo "<a href='buy.php?schedule_id={$schedule['id']}' 
                        class='dp-text-icon'>
                            <span class='blue-text'>Book Now</span>
                            <img class='small-icon' 
                            src='../icons/next.png' 
                            alt='detail'>";
                } else {
                    echo "<a class='dp-text-icon'>
                            <span class='red-text'>Now Available</span>
                            <img class='small-icon' 
                            src='../icons/cross.png' 
                            alt='detail'>";
                }
                
                echo '          </a>
                            </div>
                        </td>
                    </tr>';
            }
        }
                
        echo '  </table>
        </section>
        <section class="dp-review">
            <h3>Reviews</h3>';
        if (empty($reviews)) {
            echo '<p class="dp-empty-text">No review available yet</p>';
        } else {
            foreach ($reviews as $review) {
                $sql_query = "SELECT username, profile_picture 
                            FROM user_profile 
                            WHERE user_profile.id=?";
                $params_values = array($review['userID']);
                $user = $db->execute($sql_query, array("i"), $params_values)[0];

                echo "<div class='dp-review__row'>
                        <img class='dp-review__pic' 
                        src='{$user['profile_picture']}' alt='photo'>
                        <div>
                            <h4>{$user['username']}</h4>
                            <div class='rating'>
                                <img class='small-icon' 
                                src='../icons/star.png' alt='star'>
                                <span class='dp-rating--small'>
                                    <b>{$review['rating']}</b> / 10
                                </span>
                            </div>
                            <h5>{$review['review']}</h5>
                        </div>
                    </div>";
            }
        }
        echo '</section>
        </div>';

        ?>
    </div>

</body>
</html>