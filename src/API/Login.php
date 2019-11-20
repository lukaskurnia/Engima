<?php
/**
 * API Endpoint for Login
 * Php version 7.2.19
 *
 * @category back-end
 * @package  API
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

use engima\Database;

require_once '../db/database.php';
require_once '../components/includes/helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new engima\Database("127.0.0.1", "root", "", "enigma");
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql_query = "SELECT id,username FROM user_profile WHERE email=? and password=?";
    $result = $db->execute($sql_query, array("s","s"), array($email,$password))[0];
    if ($result != null) {
        setBrowserCookie($result['id'], $result['username']);
        header("HTTP/1.1 302 Found");
        header("Location: ../components/home.php");
    } else {
        header("HTTP/1.1 302 Found");
        header("Location: ../components/login.php");
    }
}
