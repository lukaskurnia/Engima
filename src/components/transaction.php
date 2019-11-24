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
        
        require_once "../db/database.php";
        require_once "includes/helper.php";
        require_once "includes/redirect.php";
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


        // GET data from ws-transaction
        $ch = curl_init();
        $url = "http://107.21.9.12:4000/transactions/" . $user_id; //WS-Transaction URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $output=curl_exec($ch);
        curl_close($ch);
        
        $rawdata = json_decode($output); // Data result container

        //Check container data count
        if (count($rawdata->values) == 0) {
            echo "<h3 class='grey-text'>You haven't made any purchase yet.</h3>";
        } else {
            
            // Create array to combine data from ws-transaction and db query
        foreach ($rawdata->values as $data) {
                $data->order_id = -1;
                $data->review = null;
        }

            foreach ($transactions as $transaction) {
                foreach ($rawdata->values as $data) {
                    $mov = $data->movie_id;
                    $seat = $data->seat_number;
                    if ($mov == $transaction['movie_id'] and $seat = $transaction['seat_number']) {
                        $data->order_id = $transaction['order_id'];
                        $data->review = $transaction['review'];
                    }
                }
            }

            //Get current time to see wheter the txn has expired or not
            date_default_timezone_set('Asia/Jakarta');
            $curr_date = date('Y-m-d h:i:s', time());
            $curr = strtotime($curr_date); // Convert datetime format to unix fromat in seconds

            //Prepare connection to update ws-transaction database
            $url = "http://107.21.9.12:4000/transactions";//WS-Transaction URL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

            $index = count($rawdata->values) - 1;

            //Loop for each txn data contained
            for ($idx=$index; $idx>=0; $idx--) {
                $api_key = '2dc9c50e0d06264a13a9e6953b693bba';
                $urlGetData = "https://api.themoviedb.org/3/movie/" . $rawdata->values[$idx]->movie_id .
                "?api_key=" . $api_key;
                $get_data = callAPI('GET', $urlGetData, false);
                $movie_data = json_decode($get_data, true);
                $datetime = strtotime($rawdata->values[$idx]->mov_schedule); //movie schedule
                $formatted = date('F j, Y - h:i A', $datetime);

                $no_transaksi = $rawdata->values[$idx]->txn_id;
                $status = $rawdata->values[$idx]->txn_status;
                
                if ($status == "PENDING") {
                    $created_time = strtotime($rawdata->values[$idx]->created_on);//txn[idx]'s created time
                    $temp = date('m/d/Y h:i:s a', $created_time); //debuging purpose
                    $diff = abs($curr-$created_time);

                    
                    //Connection to WS-BANK
                    $expired_time = strtotime($curr_date) + 120;
                    $formatted_expired_time = date('Y-m-d h:i:s a', $expired_time);

                    $field1 = $rawdata->values[$idx]->virtual_acc; // destination acc number
                    $field2 = 40000; //fixed amount
                    $field3 = $created_time;
                    $field4 = (string)$formatted_expired_time; // txn expired on (start time + 120sec)

                    $checkTransaction = '<?xml version="1.0" encoding="UTF-8"?> <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                        <Body>
                            <CheckTransaction xmlns="http://services/">
                                <destRek xmlns="">'.$field1.'</destRek>
                                <amount xmlns="">'.$field2.'</amount>
                                <startTime xmlns="">'.$field3.'</startTime>
                                <endTime xmlns="">'.$field4.'</endTime>
                            </CheckTransaction>
                        </Body>
                    </Envelope>';
                    $function = $checkTransaction;

                    $feature_route = "CheckTransaction";
                    $url = "http://localhost:8080/ws-bank-1.0-SNAPSHOT/services/" . $feature_route; //NEED CHANGE

                    $crl = curl_init();
                    curl_setopt($crl, CURLOPT_URL, $url);
                    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($crl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($crl, CURLOPT_POST, true);
                    curl_setopt($crl, CURLOPT_POSTFIELDS, $function);
                    curl_setopt($crl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml; charset=utf-8", "Content-Length: " . strlen($function)));
                    $output = curl_exec($crl);
                    curl_close($crl);

                    $out = <<<EOF
                    $output
                    EOF;

                    $parser = simplexml_load_string($out);  
                    $parserEnv = $parser->children('S',true);
                    $returns = $parserEnv->Body->children('ns2',true)
                        ->CheckTransactionResponse->children();

                    $return = $returns->return;
                    echo "status:  ";
                    echo $return;
                    if($return == 200){
                        $status = "COMPLETED";
                    } elseif($return == 400){
                        $status = "CANCELLED";
                    }

                    if($status !="PENDING"){
                        $data = array("txn_id"=>$no_transaksi,"txn_status" => $status);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                        $response = curl_exec($ch);
                    }  
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
                    if ($rawdata->values[$idx]->review==null) {
                        echo "<div class='tp-content__detail'>
                                <a href='review.php?order_id={$rawdata->values[$idx]->order_id}'
                                class='tp-button blue-background'>
                                    Add Review
                                </a>
                            </div >";
                    } else {
                        echo "<div class='tp-content__detail'>
                                <button id={$rawdata->values[$idx]->order_id} 
                                class='tp-button red-background'>Delete Review</button>
                                <a href='review.php?order_id={$rawdata->values[$idx]->order_id}'
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