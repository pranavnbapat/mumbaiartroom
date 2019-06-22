<?php

/*
 * @package  for DB connection
 * @author   pranav bapat
 * @license  GNU GENERAL PUBLIC LICENSE
 * @access   Public + Private
 * @php      5 or higher
 *
 */

class DbaseMySQL {
    /*
     * Connection information
     */

    protected $mySQLUser = "htmlcssi_pranavb";
    protected $mySQLPasswd = "eT%+Ni72a.!}";
    protected $mySQLHost = "localhost";
    protected $mySQLPort = "3306";
    protected $mySQLName = "htmlcssi_mumbaiartroom";
    protected $mySQLSelectDB;
    protected $mySQLConnection;

    /*
     * DbaseMySQL class constructor
     *
     * Initializes the DbaseMySQL class
     * @access public
     * @param none
     * @return string $this->mySQLConnect()
     */

    public function __construct() {

        return $this->mySQLConnect();
    }

    /*
     * Provides an OOP interface to an MySQL host
     * @param none
     * @return boolean
     */

    public function mySQLConnect() {
        $this->mySQLConnection = new mysqli($this->mySQLHost, $this->mySQLUser, $this->mySQLPasswd, $this->mySQLName);
        if ($this->mySQLConnection->connect_errno) {
            printf("Connect failed: %s\n", $this->mySQLConnection->connect_error);
            exit();
        } else {
            return $this->mySQLConnection;
        }
    }

    /*
     * closing connection from MySQL host
     * @param none
     * @return boolean
     */

    public function mysqlclose() {
        // close connection
        $this->mySQLConnection->close();
    }

}

?>