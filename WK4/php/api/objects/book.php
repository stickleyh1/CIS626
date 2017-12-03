<?php
class Book{
 
    // database connection and table name
    private $conn;
    private $table_name = "books";
 
    // object properties
    public $ISBN;
    public $AuthorFirstName;
    public $AuthorLastName;
    public $Title;
    public $Pages;
    public $Publisher;
    public $PublicationYear;
    public $Topic;
    public $Available;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read books
    function read(){
    
       // select all query
       $query = "SELECT
                   ISBN,CONCAT(AuthorFirstName,' ',AuthorLastName) AS AuthorName,Title,Pages,Publisher,PublicationYear,Topic,Available
                FROM
                   " . $this->table_name . " b";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // execute query
       $stmt->execute();
    
       return $stmt;
   }

    // create book
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
               ISBN=:ISBN,AuthorFirstName=:AuthorFirstName,AuthorLastName=:AuthorLastName,Title=:Title,Pages=:Pages,Publisher=:Publisher,PublicationYear=:PublicationYear,Topic=:Topic,Available=:Available";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->ISBN=htmlspecialchars(strip_tags($this->ISBN));
       $this->AuthorFirstName=htmlspecialchars(strip_tags($this->AuthorFirstName));
       $this->AuthorLastName=htmlspecialchars(strip_tags($this->AuthorLastName));
       $this->Title=htmlspecialchars(strip_tags($this->Title));
       $this->Pages=htmlspecialchars(strip_tags($this->Pages));
       $this->Publisher=htmlspecialchars(strip_tags($this->Publisher));
       $this->PublicationYear=htmlspecialchars(strip_tags($this->PublicationYear));
       $this->Topic=htmlspecialchars(strip_tags($this->Topic));
       $this->Available=htmlspecialchars(strip_tags($this->Available));
       
    
       // bind values
       $stmt->bindParam(':ISBN', $this->ISBN);
       $stmt->bindParam(':AuthorFirstName', $this->AuthorFirstName);
       $stmt->bindParam(':AuthorLastName', $this->AuthorLastName);
       $stmt->bindParam(':Title', $this->Title);
       $stmt->bindParam(':Pages', $this->Pages);
       $stmt->bindParam(':Publisher', $this->Publisher);
       $stmt->bindParam(':PublicationYear', $this->PublicationYear);
       $stmt->bindParam(':Topic', $this->Topic);
       $stmt->bindParam(':Available', $this->Available);
       
    
       // execute query
       if($stmt->execute()){
           return true;
       }else{
           return false;
       }
   }

    // update the book
    function update(){
    
       // update query
       $query = "UPDATE
                   " . $this->table_name . "
               SET
                   AuthorFirstName=:AuthorFirstName,AuthorLastName=:AuthorLastName,Title=:Title,Pages=:Pages,Publisher=:Publisher,PublicationYear=:PublicationYear,Topic=:Topic,Available=:Available
    
               WHERE
                    ISBN=:ISBN";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->AuthorFirstName=htmlspecialchars(strip_tags($this->AuthorFirstName));
       $this->AuthorLastName=htmlspecialchars(strip_tags($this->AuthorLastName));
       $this->Title=htmlspecialchars(strip_tags($this->Title));
       $this->Pages=htmlspecialchars(strip_tags($this->Pages));
       $this->Publisher=htmlspecialchars(strip_tags($this->Publisher));
       $this->PublicationYear=htmlspecialchars(strip_tags($this->PublicationYear));
       $this->Topic=htmlspecialchars(strip_tags($this->Topic));
       $this->Available=htmlspecialchars(strip_tags($this->Available));
       $this->ISBN=htmlspecialchars(strip_tags($this->ISBN));
    
       // bind new values
       $stmt->bindParam(':AuthorFirstName', $this->AuthorFirstName);
       $stmt->bindParam(':AuthorLastName', $this->AuthorLastName);
       $stmt->bindParam(':Title', $this->Title);
       $stmt->bindParam(':Pages', $this->Pages);
       $stmt->bindParam(':Publisher', $this->Publisher);
       $stmt->bindParam(':PublicationYear', $this->PublicationYear);
       $stmt->bindParam(':Topic', $this->Topic);
       $stmt->bindParam(':Available', $this->Available);
       $stmt->bindParam(':ISBN', $this->ISBN);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }else{
           return false;
       }
   }

    // search books
    function search($keywords){
    
       // select all query
       $query = "SELECT
                   ISBN,CONCAT(AuthorFirstName,' ',AuthorLastName) AS AuthorName,Title,Pages,Publisher,PublicationYear,Topic,Available
               FROM
                   " . $this->table_name . " b
               WHERE
                   b.ISBN LIKE ? OR b.AuthorLastName LIKE ? OR b.Title LIKE ? OR b.Topic LIKE ?";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $keywords=htmlspecialchars(strip_tags($keywords));
       $keywords = "%{$keywords}%";
    
       // bind
       $stmt->bindParam(1, $keywords);
       $stmt->bindParam(2, $keywords);
       $stmt->bindParam(3, $keywords);
       $stmt->bindParam(4, $keywords);
    
       // execute query
       $stmt->execute();
    
       return $stmt;
   }

     // used for paging books
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}