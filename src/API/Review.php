<?php
/**
 * API Endpoint for Review
 * Php version 7.2.19
 *
 * @category back-end
 * @package  API
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

require_once '../db/database.php';

$db = new Database("127.0.0.1", "root", "", "enigma");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $rating = (int)$_POST['rating'];
    $review = $_POST['review'];
    $sql_query = "INSERT INTO rating (orders_id, rating, review) VALUES (?, ?, ?)";
    $params_type = array("i","i","s");
    $params_values = array($order_id,$rating,$review);
    $status = $db->execute($sql_query, $params_type, $params_values);
    echo $status;
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    foreach ($_PUT as $key => $value) {
        unset($_PUT[$key]);
        $_PUT[str_replace('amp;', '', $key)] = $value;
    }
    $_REQUEST = array_merge($_REQUEST, $_PUT);
    
    $order_id = $_PUT['order_id'];
    $rating = (int)$_PUT['rating'];
    $review = $_PUT['review'];
    $sql_query = "UPDATE rating 
                SET rating.rating=?,rating.review=? 
                WHERE rating.orders_id = ?";

    $params_type = array("i","s","i");
    $params_values = array($rating,$review,$order_id);
    $status = $db->execute($sql_query, $params_type, $params_values);
    echo $status;
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    foreach ($_DELETE as $key => $value) {
        unset($_DELETE[$key]);
        $_DELETE[str_replace('amp;', '', $key)] = $value;
    }
    $_REQUEST = array_merge($_REQUEST, $_DELETE);
    $order_id = $_DELETE['order_id'];

    $sql_query = "DELETE FROM rating WHERE rating.orders_id = ?";
    $status = $db->execute($sql_query, array("i"), array($order_id));
    echo $status;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $order_id = $_GET['order_id'];
    $sql_query = "SELECT rating,review,movie_name FROM (((
                    orders as ord LEFT JOIN rating ON (ord.id=rating.orders_id))
                    JOIN schedule ON (schedule.id=ord.schedule_id))
                    JOIN movies ON movies.id = schedule.movie_id)
                WHERE ord.id=?";
    $reviews = $db->execute($sql_query, array("i"), array($order_id))[0];
    echo json_encode($reviews);
}
