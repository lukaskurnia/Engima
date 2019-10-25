<?php
/**
 * Review Page front-end
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
    <title>Engima | Review</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php
        require_once "includes/redirect.php";
        require_once "navbar.php";
    ?>

    <div id="mainContent" class="wrapper">
        <section class="rp-title">
            <button id="backButton" class="bp-back-button"><img class="bp-title__back-icon" 
            src="../icons/back.png" alt="back"></button>
            <div>
                <h2 id="movieTitle">Loading title...</h2>
            </div>
        </section>

        <section class="rp-reviewform">
            <div class="rp-review">
                <div class="rp-label">
                    Add Rating
                </div>
                <div class="rp-star-area">
                    <label id="star1" class="rp-star-icon">&#9733;</label>
                    <label id="star2" class="rp-star-icon">&#9733;</label>
                    <label id="star3" class="rp-star-icon">&#9733;</label>
                    <label id="star4" class="rp-star-icon">&#9733;</label>
                    <label id="star5" class="rp-star-icon">&#9733;</label>
                    <label id="star6" class="rp-star-icon">&#9733;</label>
                    <label id="star7" class="rp-star-icon">&#9733;</label>
                    <label id="star8" class="rp-star-icon">&#9733;</label>
                    <label id="star9" class="rp-star-icon">&#9733;</label>
                    <label id="star10" class="rp-star-icon">&#9733;</label>
                </div>
            </div>
            <div class="rp-review">
                <div class="rp-label">
                    Add Review
                </div>
                <textarea id="review" class="rp-review__input" placeholder="Your review..."></textarea>
            </div>
            <div class="rp-button-container">
                <button class="rp-button rp-button__cancel">Cancel</button>
                <button id="submitButton" class="rp-button rp-button__submit">Submit</button>
            </div>
        </section>
    </div>

    <div id="confirmationModal" class="modal">
        <div class="modal__wrapper">
            <h2 id="modalTitle" class="blue-text">
                Review Submitted!
            </h2>
            <div id="modalDesc" class="modal__message">
                Thank you for review.
            </div>
            <a href="transaction.php" class="modal__button blue-background">Go to transaction history</a>
        </div>
    </div>

    <script type="text/javascript" src="includes/js/review.js"></script>
</body>

</html>