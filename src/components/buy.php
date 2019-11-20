<?php
/**
 * Buy Page front-end
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
    <title>Engima | Buy</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php
        require_once "includes/redirect.php";
        require_once "../db/database.php";
        require_once "includes/helper.php";
        require_once "navbar.php";

        $user_id = lookUpId();
        $username = getUsername($user_id);
        echo "<input type='hidden' id='userId' value={$user_id}>";
    ?>

    <div id="mainContent" class="wrapper">
        <section class="bp-title">
            <button id="backButton" class="bp-back-button">
                <img class="bp-title__back-icon" src="../icons/back.png" alt="back">
            </button>
            <div>
                <h2 id="movieTitle">Loading...</h2>
                <h3 id="scheduleTime">Loading...</h3>

            </div>
        </section>

        <div class="bp-grid-container">
            <section class="bp-seats">
                <div class="bp-seats__button-area">
                    <button id="btn1" class="bp-seats__button">1</button>
                    <button id="btn2" class="bp-seats__button">2</button>
                    <button id="btn3" class="bp-seats__button">3</button>
                    <button id="btn4" class="bp-seats__button">4</button>
                    <button id="btn5" class="bp-seats__button">5</button>
                    <button id="btn6" class="bp-seats__button">6</button>
                    <button id="btn7" class="bp-seats__button">7</button>
                    <button id="btn8" class="bp-seats__button">8</button>
                    <button id="btn9" class="bp-seats__button">9</button>
                    <button id="btn10" class="bp-seats__button">10</button>
                    <button id="btn11" class="bp-seats__button">11</button>
                    <button id="btn12" class="bp-seats__button">12</button>
                    <button id="btn13" class="bp-seats__button">13</button>
                    <button id="btn14" class="bp-seats__button">14</button>
                    <button id="btn15" class="bp-seats__button">15</button>
                    <button id="btn16" class="bp-seats__button">16</button>
                    <button id="btn17" class="bp-seats__button">17</button>
                    <button id="btn18" class="bp-seats__button">18</button>
                    <button id="btn19" class="bp-seats__button">19</button>
                    <button id="btn20" class="bp-seats__button">20</button>
                    <button id="btn21" class="bp-seats__button">21</button>
                    <button id="btn22" class="bp-seats__button">22</button>
                    <button id="btn23" class="bp-seats__button">23</button>
                    <button id="btn24" class="bp-seats__button">24</button>
                    <button id="btn25" class="bp-seats__button">25</button>
                    <button id="btn26" class="bp-seats__button">26</button>
                    <button id="btn27" class="bp-seats__button">27</button>
                    <button id="btn28" class="bp-seats__button">28</button>
                    <button id="btn29" class="bp-seats__button">29</button>
                    <button id="btn30" class="bp-seats__button">30</button>
                </div>
                <div class="bp-seats__screen">
                    Screen
                </div>
            </section>
            <section class="bp-confirmation">
                <h2>Booking Summary</h2>
                <div id="confirmationContent">
                    <h4 class="grey-text">You haven's selected any seat yet. Please click on one of the seat provided.
                    </h4>
                </div>
            </section>
        </div>
    </div>

    <?php
    $no_transaksi = 1;
    $virtual_acc = 1234567890;
    echo "<div id='confirmationModal' class='modal'>
        <div class='modal__wrapper'>
            <h2 class='blue-text'>
                Transaction no. {$no_transaksi}
            </h2>
            <div class='modal__message'>
                Please Transfer to this Virtual Account : {$virtual_acc}
            </div>
            <a href='transaction.php' class='modal__button blue-background'>Go to transaction history</a>
        </div>
    </div>"
    ?>

    <script type="text/javascript" src="includes/js/buy.js"></script>
</body>

</html>