<?php
/**
 * Page Redirector when cookies not present
 * Php version 7.2.19
 *
 * @category back-end
 * @package  components
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

// require_once '../db/database.php';
require_once "helper.php";

$user_id = lookUpId();
if ($user_id==-1) {
    // $login_url = "/src/components/login.php";
    // $register_url = "/src/components/register.php";
    // if (!($_SERVER['REQUEST_URI']==$login_url || $_SERVER['REQUEST_URI']==$register_url)) {
        header("HTTP/1.1 302 Found");
        header("Location: ../components/login.php");
    // }
}
