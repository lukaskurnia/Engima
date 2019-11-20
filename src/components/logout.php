<?php
/**
 * Logout back-end
 * Php version 7.2.19
 *
 * @category Back-End Cookies
 * @package  Components
 * @author   Aldo Azali <13516125@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

use engima\Database;

include_once "../db/database.php";

$db = new engima\Database("127.0.0.1", "root", "", "enigma");

$access_token = $_COOKIE["accessToken"];
$sql_query = "DELETE FROM server_session WHERE access_token = ?";

$status=$db->execute($sql_query, array("i"), array($access_token));

setcookie('accessToken', null, time()+1, "/");
header("HTTP/1.1 302 Found");
header('Location: login.php');
