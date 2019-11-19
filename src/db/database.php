<?php 
// namespace engima;

/**
 * Implement of database connection
 * Php version 7.2.19
 *
 * @category Dbconnection
 * @package  Dbconnection
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

 /**
  * Database real class to execute query
  * @category Dbconnection
  * @package  Dbconnection
  * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
  * @license  no license
  * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
  */

// namespace db;

class Database
{
    private $server;
    private $user;
    private $password;
    private $dbName;
    private $conn;

    /**
     * Constructor for Database class
     * @param string $server   the hosting server url
     * @param string $user     username for host login
     * @param string $password password for host login
     * @param string $dbName   name of database to access
     */
    public function __construct($server, $user, $password, $dbName)
    {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->conn  =  mysqli_connect($server, $user, $password, $dbName);
    }

    /**
     * Function to execute sql query automatically and prevent sql injection
     * @param string $template  query for sql
     * @param array  $valueType array of char
     * @param array  $values    array of values corresponding to $valueType
     * @return array query result (if any)
     */
    public function execute($template, $valueType, $values)
    {
        $stmt = $this->conn->prepare($template);
        $param_length = count($values);
        $param_type = "";
        $params = array();

        for ($i = 0; $i < $param_length; $i++) {
            $param_type .= $valueType[$i];
        }

        $params[] = &$param_type;

        for ($i = 0; $i < $param_length; $i++) {
            $params[] = &$values[$i];
        }

        call_user_func_array(array($stmt, "bind_param"), $params);
        $stmt->execute();

        if ($stmt) {
            $result = $stmt->get_result();
    
            if ($result) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($data, $row);
                }
                return $data;
            } else {
                return 200;
            }
        } else {
            return 500;
        }
    }
}
