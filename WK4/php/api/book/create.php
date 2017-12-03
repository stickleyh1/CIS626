<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate book object
include_once '../objects/book.php';
 
$database = new Database();
$db = $database->getConnection();
 
$book = new Book($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set book property values
$book->ISBN = $data->ISBN;
$book->AuthorFirstName = $data->AuthorFirstName;
$book->AuthorLastName = $data->AuthorLastName;
$book->Title = $data->Title;
$book->Pages = $data->Pages;
$book->Publisher = $data->Publisher;
$book->PublicationYear = $data->PublicationYear;
$book->Topic = $data->Topic;
$book->Available = $data->Available;
 
// create the book
if($book->create()){
    echo '{';
        echo '"message": "Book was created."';
    echo '}';
}
 
// if unable to create the book, tell the user
else{
    echo '{';
        echo '"message": "Unable to create book."';
    echo '}';
}
?>