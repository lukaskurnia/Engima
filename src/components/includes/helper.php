<?php
// namespace engima;

/**
 * Helper function for cookies checking
 * Php version 7.2.19
 *
 * @category back-end
 * @package  components
 * @author   Aldo Azali <13516125@std.stei.itb.ac.id>
 *           Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

 use engima\Database;

// require_once '../db/database.php';

// Method to generate random access token based on user id

function genAccessToken($id, $username)
{
    // Random factor is time (now)
    $date = date("Y-m-d H:i:s");
    // Hash it with hmac function
    $string = $id . "." . $username . "." . $date;
    $signature = hash_hmac('sha256', $string, 'engima', true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    return $base64UrlSignature;
}

// Method to find corresponding access token, return id
function lookUpId()
{
    $access_token = $_COOKIE['accessToken'];
    if ($access_token == null) {
        return -1;
    } else {
        $db = new engima\Database("127.0.0.1", "root", "", "enigma");
        $sql_query = "SELECT user_id FROM server_session WHERE access_token = ?";
        $user_id = $db->execute($sql_query, array("s"), array($access_token))[0];
        if ($user_id == null) {
            return -1;
        } else {
            return $user_id['user_id'];
        }
    }
}

function getUsername($id)
{
    $db = new engima\Database("127.0.0.1", "root", "", "enigma");
    $sql_query = "SELECT username FROM user_profile WHERE id=?";
    $result = $db->execute($sql_query, array("i"), array($id))[0];
    return $result['username'];
}

function setBrowserCookie($id, $username)
{
    $db = new engima\Database("127.0.0.1", "root", "", "enigma");
    $access_token = genAccessToken($id, $username);
    $sql_query = 'INSERT INTO server_session (user_id, access_token) 
                VALUES (?, ?)';
    $param_types = array("i","s");
    $param_values = array($id, $access_token);
    $status = $db->execute($sql_query, $param_types, $param_values);
    
    if ($status == 200) {
        setcookie('accessToken', $access_token, time()+600, "/");
    }
    return $status;
}
