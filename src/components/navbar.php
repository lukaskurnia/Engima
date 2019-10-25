<?php
/**
 * Navbar
 * Php version 7.2.19
 *
 * @category Front-end
 * @package  Components
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */
?>

<nav class="header">
    <div class="header__container">
        <a class="header__title" href="home.php"><b class="header__title--blue">Engi</b>ma</a>
        <div class="search-bar">
            <form action="search.php">
                <input type="text" placeholder="Search movie" name="query">
                <button type="submit"><img src="../icons/search.png" alt="Go"></button>
            </form>
        </div>
    </div>
    <div class="header__container">
        <div class="header__link"><a href="transaction.php">Transactions</a></div>
        <div class="header__link"><a href="logout.php">Logout</a></div>
    </div>
</nav>