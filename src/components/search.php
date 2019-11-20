<?php
/**
 * Search Page front-end
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
    <title>Engima | Search</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php
        require_once "includes/redirect.php";
        require_once "navbar.php";
    ?>
    <section id="mainContent" class="wrapper">
        <h3><b>Loading movies...</b></h3>
    </section>


    <script type="text/javascript" src="includes/js/search.js"></script>
</body>

</html>