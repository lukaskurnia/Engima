<?php
/**
 * API Endpoint for Buy
 * Php version 7.2.19
 *
 * @category back-end
 * @package  API
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

use engima\Database;

require_once '../components/includes/helper.php';
require_once '../db/database.php';


$db = new engima\Database("127.0.0.1", "root", "", "enigma");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedule_id = (int)$_POST["schedule_id"];
    $seat_number = (int)$_POST["seat_number"];
    $user_id = (int)$_POST['user_id'];
    $sql_query = "INSERT INTO orders 
                (schedule_id, seat_number, user_id)
                VALUES (?,?,?)";
    
    $params_type = array("i","i","i");
    $params_values = array($schedule_id,$seat_number,$user_id);
    $status = $db->execute($sql_query, $params_type, $params_values);
    
    //Setting data for aws database
    $query = "SELECT * FROM schedule JOIN orders ON schedule.id = orders.schedule_id WHERE schedule.id=?"; //Buat dapetin movie id
    $query_res = $db->execute($query, array("i"), array($schedule_id))[0];

    date_default_timezone_set('Asia/Jakarta');
    $curr_date = date('Y-m-d h:i:s', time());

    $data = new \stdClass();
    $virtual_account = '111222'; // From ws-bank ### NEED EDIT ###

    $data->user_id = $user_id;
    $data->virtual_acc = $virtual_account;
    $data->movie_id = $query_res["movie_id"];
    $data->mov_schedule = $query_res["datetime"];
    $data->seat_number = $seat_number;
    $data->created_on = "" . (string)$curr_date;

    $payload = json_encode($data);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://107.21.9.12:4000/transactions");//WS-Transaction URL
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload))
    );

    $server_output = curl_exec($ch);
    curl_close ($ch);

    $raw = json_decode($server_output);

    $result = array();
    $result["status"] = "".$status."";
    $result["txn_id"] = $raw->values;
    $result["virtual_acc"] = $virtual_account;
    $package = json_encode($result);

    echo $package;

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $schedule_id = (int)$_GET["schedule_id"];
    
    $sql_query = "SELECT * FROM schedule WHERE schedule.id=?"; //Buat dapetin movie id
    $schedule_data = $db->execute($sql_query, array("i"), array($schedule_id))[0];
    
    $movie_id = (int)$schedule_data['movie_id'];

    
    $api_key = '2dc9c50e0d06264a13a9e6953b693bba';
    $urlGetData = "https://api.themoviedb.org/3/movie/" . $movie_id .
    "?api_key=" . $api_key;
    $get_data = callAPI('GET', $urlGetData, false);
    $movie_data = json_decode($get_data, true);
    // echo $movie_data['title'];

    // $sql_query = "SELECT movie_name,price FROM movies WHERE movies.id=?";
    // $movie_data = $db->execute($sql_query, array("i"), array($movie_id))[0];
    
    $datetime = strtotime($schedule_data['datetime']);
    $datetime = date('F j, Y - h:i A', $datetime);
    
    $sql_query = "SELECT seat_number FROM orders WHERE orders.schedule_id=?"; //Buat dapetin seatnumbe
    $order_data = $db->execute($sql_query, array("i"), array($schedule_id));
    
    $result = array();
    $result["movie"] = $movie_data['title'];
    $result["datetime"] = $datetime;
    $result["seats"] = $order_data;
    
    echo json_encode($result);
}
