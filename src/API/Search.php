<?php
/**
 * API Endpoint for Search
 * Php version 7.2.19
 *
 * @category back-end
 * @package  API
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

require_once '../db/database.php';

if (isset($_GET["query"])) {
    $query = "%{$_GET["query"]}%";

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
                WHERE movies.movie_name LIKE ?";
    $movie_list = $db->execute($sql_query, array("s"), array($query));
        
    echo json_encode($movie_list);
}
