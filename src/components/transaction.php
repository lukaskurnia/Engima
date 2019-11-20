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
        
        $sql_query = "SELECT ord.id AS order_id,
                    movie_name,movie_pictures,
                    datetime,review 
                    FROM (((
                        orders as ord LEFT JOIN rating ON (ord.id=rating.orders_id))
                        JOIN schedule ON (schedule.id=ord.schedule_id))
                        JOIN movies ON movies.id = schedule.movie_id)
                    WHERE ord.user_id=? ORDER BY datetime DESC";
        $transactions = $db->execute($sql_query, array("i"), array($user_id));

        if (empty($transactions)) {
            echo "<h3 class='grey-text'>You haven't made any purchase yet.</h3>";
        } else {
            foreach ($transactions as $transaction) {
                $datetime = strtotime($transaction['datetime']);
                $formatted = date('F j, Y - h:i A', $datetime);
                echo "<div class='tp-content__row'>
                    <div class='tp-content__left'>
                        <div class='tp-content__image'>
                            <img class='poster' src='{$transaction['movie_pictures']}' alt='Movie poster'>
                        </div>
                        <div class='tp-content__desc'>
                            <h2>{$transaction['movie_name']}</h2>
                            <h3><span class='tp-schedule blue-text'>Schedule:</span>{$formatted}</h3>
                        </div>
                    </div>";
                if (time() > $datetime) {
                    if ($transaction['review']==null) {
                        echo "<div class='tp-content__detail'>
                                <a href='review.php?order_id={$transaction['order_id']}'
                                class='tp-button blue-background'>
                                    Add Review
                                </a>
                            </div >";
                    } else {
                        echo "<div class='tp-content__detail'>
                                <button id={$transaction['order_id']} 
                                class='tp-button red-background'>Delete Review</button>
                                <a href='review.php?order_id={$transaction['order_id']}'
                                class='tp-button green-background'>
                                    Edit Review
                                </a>
                            </div>";
                    }
                }
                echo '</div>';
            }
        }
        ?>
        </div>
    </section>
    <script type="text/javascript" src="includes/js/transaction.js"></script>
</body>

</html>