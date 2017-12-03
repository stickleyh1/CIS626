<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/book.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare book object
$book = new Book($db);
 
// get id of book to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of book to be edited
$book->ISBN = $data->ISBN;
 
// set book property values
$book->AuthorFirstName = $data->AuthorFirstName;
$book->AuthorLastName = $data->AuthorLastName;
$book->Title = $data->Title;
$book->Pages = $data->Pages;
$book->Publisher = $data->Publisher;
$book->PublicationYear = $data->PublicationYear;
$book->Topic = $data->Topic;
$book->Available = $data->Available;
 
// update the book
if($book->update()){
    echo '{';
        echo '"message": "Book was updated."';
    echo '}';
}
 
// if unable to update the book, tell the user
else{
    echo '{';
        echo '"message": "Unable to update book."';
    echo '}';
}
?>