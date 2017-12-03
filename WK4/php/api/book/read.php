<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/book.php';
 
// instantiate database and book object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$book = new Book($db);
 
// query books
$stmt = $book->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // books array
    $books_arr=array();
    $books_arr["data"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        extract($row);
 
        $book_item=array(
            "ISBN" => $ISBN,
            "AuthorFirstName" => $AuthorFirstName,
            "AuthorLastName" => $AuthorLastName,
            "Title" => html_entity_decode($Title),
            "Pages" => $Pages,
            "Publisher" => $Publisher,
            "PublicationYear" => $PublicationYear,
            "Topic" => $Topic,
            "Available" => $Available,
        );
 
        array_push($books_arr["data"], $book_item);
    }
 
    echo json_encode($books_arr);
}
 
else{
    echo json_encode(
        array("message" => "No books found.")
    );
}
?>