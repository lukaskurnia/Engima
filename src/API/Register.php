<?php

/**
 * API Endpoint for Register
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

    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = strtolower(end(explode('.', $fileName)));
    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileExt, $allowed)) {
        if ($fileError == 0) {
            $fileNewName = $username . "." . $fileExt;
            $fileDestination = '../pictures/profiles/' . $fileNewName;
            move_uploaded_file($fileTmpName, $fileDestination);
        }
    }

    $sql_query = "INSERT INTO user_profile 
                (username, email, phone_number, password, profile_picture)
                VALUES
                (?, ?, ?, ?, ?)";

    $param_types = array("s","s","s","s","s");
    $param_values = array($username, $email, $phone_number, $password, $fileDestination);
    $status = $db->execute($sql_query, $param_types, $param_values);

    $sql_query = "SELECT id,username from user_profile WHERE username=?";
    $result = $db->execute($sql_query, array("s"), array($username))[0];

    if ($result != null) {
        setBrowserCookie($result['id'], $result['username']);
        header("HTTP/1.1 302 Found");
        header("Location: ../components/home.php");
    } else {
        header("HTTP/1.1 302 Found");
        header("Location: ../components/register.php");
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $db = new engima\Database("127.0.0.1", "root", "", "enigma");
    $username = $_GET['username'];

    $sql_query = "SELECT * FROM user_profile WHERE username = ?";
    $result = $db->execute($sql_query, array("s"), array($username));
    echo json_encode($result);
}
