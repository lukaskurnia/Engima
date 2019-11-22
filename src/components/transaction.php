<?php
/**
 * Transaction Page front-end
 * Php version 7.2.19
 *
 * @category front-end
 * @package  components
 * @author   Ridwan Faturrahman <13517150@std.stei.itb.ac.id>
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
    <title>Engima | Transaction</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php
        use engima\Database;
        
        require_once "includes/redirect.php";
        require_once "../db/database.php";
        require_once "includes/helper.php";
        require_once "navbar.php"
    ?>

    <section id="mainContent" class="wrapper">
        <div class="tp-content__wrapper">
            <h1 class="tp-title">Transactions History</h1>
        <?php

        $db = new engima\Database("127.0.0.1", "root", "", "enigma");
        $user_id = lookUpId();
        
        $sql_query = "SELECT ord.id AS order_id,datetime,review,seat_number,movie_id 
                    FROM ((
                        orders as ord LEFT JOIN rating ON (ord.id=rating.orders_id))
                        JOIN schedule ON (schedule.id=ord.schedule_id))
                    WHERE ord.user_id=? ORDER BY datetime DESC";
        $transactions = $db->execute($sql_query, array("i"), array($user_id));

        $ch = curl_init();
        $url = "http://18.207.173.183:4000/transactions/" . $user_id;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
        $output=curl_exec($ch);
        curl_close($ch);
        
        $rawdata = json_decode($output);

        if (count($rawdata->values) == 0) {
            echo "<h3 class='grey-text'>You haven't made any purchase yet.</h3>";
        } else {
            //$user_id = 2;
            // $index = count($rawdata->values) - 1;
            //init
            foreach($rawdata->values as $data){
                $data->order_id = -1;
                $data->review = null;
            }

            foreach($transactions as $transaction){
                foreach($rawdata->values as $data){
                    $mov = $data->movie_id;
                    $seat = $data->seat_number;
                    if($mov == $transaction['movie_id'] AND $seat = $transaction['seat_number']){
                        $data->order_id = $transaction['order_id'];
                        $data->review = $transaction['review'];
                    }
                }
            }

            $curr_date = date('m/d/Y h:i:s a', time());
            $curr = strtotime(date('m/d/Y h:i:s a', time()));

            //Prepare connection
            $url = "http://18.207.173.183:4000/transactions";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

            foreach ($rawdata->values as $item) {
                $api_key = '2dc9c50e0d06264a13a9e6953b693bba';
                $urlGetData = "https://api.themoviedb.org/3/movie/" . $item->movie_id .
                "?api_key=" . $api_key;
                $get_data = callAPI('GET', $urlGetData, false);
                $movie_data = json_decode($get_data, true);

                $datetime = strtotime($item->mov_schedule); //movie schedule
                $formatted = date('F j, Y - h:i A', $datetime);

                //WS-Transaction
                $no_transaksi = $item->txn_id;
                $status = $item->txn_status;

                if($status != "COMPLETED"){
                    $created_time = strtotime($item->created_on);
                    $diff = abs($curr-$created_time);

                    if($diff<=120){
                        //Koneksi WS-BANK
                        $status = "COMPLETED";
                    } else{
                        $status = "CANCELLED";
                    }
                    
                    $data = array("txn_id"=>$no_transaksi,"txn_status" => $status);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
                    $response = curl_exec($ch);
                }

                echo "<div class='tp-content__row'>
                    <div class='tp-content__left'>
                        <div class='tp-content__image'>
                            <img class='poster' src='https://image.tmdb.org/t/p/w500{$movie_data['poster_path']}'
                             alt='Movie poster'>
                        </div>
                        <div class='tp-content__desc'>
                            <h1 class='tp-schedule'>Transaction <span class='blue-text'>#{$no_transaksi}</span>";
                if ($status == "PENDING") {
                                 echo "<span class='tp-status yellow-background'> PENDING";
                } elseif ($status == "COMPLETED") {
                                echo "<span class='tp-status green-background'> SUCCESS";
                } elseif ($status == "CANCELLED") {
                                echo "<span class='tp-status red-background'> CANCELLED";
                }
                            echo "</h1>
                            <h2>{$movie_data['title']}</h2>
                            <h3><span class='tp-schedule blue-text'>Schedule:</span>{$formatted}</h3>
                        </div>
                    </div>";
                if (time() > $datetime) {
                    if ($item->review==null) {
                        echo "<div class='tp-content__detail'>
                                <a href='review.php?order_id={$item->order_id}'
                                class='tp-button blue-background'>
                                    Add Review
                                </a>
                            </div >";
                    } else {
                        echo "<div class='tp-content__detail'>
                                <button id={$item->order_id} 
                                class='tp-button red-background'>Delete Review</button>
                                <a href='review.php?order_id={$item->order_id}'
                                class='tp-button green-background'>
                                    Edit Review
                                </a>
                            </div>";
                    }
                }
                echo '</div>';
            }
            curl_close($ch);
        }
        ?>
        </div>
    </section>
    <script type="text/javascript" src="includes/js/transaction.js"></script>
</body>

</html>