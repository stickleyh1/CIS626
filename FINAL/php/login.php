<?php 
// Based on http://untame.net/2013/06/how-to-build-a-functional-login-form-with-php-twitter-bootstrap/
require("./head.php");

$database = new Database();
$db = $database->getConnection();

$submitted_username = ''; 
if(!empty($_POST)){ 
    $query = " 
        SELECT 
            CustomerID, 
            Username, 
            Password, 
            Email,
            Admin
        FROM Customers
        WHERE 
            Username = :Username 
    "; 
    $query_params = array( 
        ':Username' => $_POST['Username'] 
    ); 
      
    try{ 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex){ header("Location: catalog.php?loginFailed=true"); } 
    $login_ok = false; 
    $row = $stmt->fetch(); 
    if($row){ 
        $check_password = hash('sha256', $_POST['Password']); 
        for($round = 0; $round < 65536; $round++){
            $check_password = hash('sha256', $check_password);
        } 
        if($check_password === $row['Password']){
            $login_ok = true;
        } 
    } 

    if($login_ok){ 
        unset($row['Password']); 
        $_SESSION['user'] = $row;  
        header("Location: catalog.php");
    } 
    else{ 
        header("Location: catalog.php?loginFailed=true");
        $submitted_username = htmlentities($_POST['Username'], ENT_QUOTES, 'UTF-8'); 
    } 
} 
?> 