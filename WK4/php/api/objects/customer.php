<?php
class Customer{
 
    // database connection and table name
    private $conn;
    private $table_name = "customers";
 
    // object properties
    public $CustomerID;
    public $Username;
    public $Email;
    public $Password;
    public $Admin;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}