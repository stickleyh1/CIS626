<?php 
    // Based on http://untame.net/2013/06/how-to-build-a-functional-login-form-with-php-twitter-bootstrap/
    require("./head.php");
    if(!empty($_POST)) 
    { 
        $database = new Database();
        $db = $database->getConnection();

        // Check if the username is already taken
        $query = " 
            SELECT 
                1 
            FROM customers 
            WHERE 
                Username = ':Username'
        "; 
        $query_params = array( ':Username' => $_POST['Username'] ); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ header("Location: catalog.php?registerFailed=true"); } 
        $row = $stmt->fetch(); 
        if($row){ header("Location: catalog.php?registerFailed=email"); } 
        $query = " 
            SELECT 
                1 
            FROM customers 
            WHERE 
                Email = ':Email' 
        "; 
        $query_params = array( 
            ':Email' => $_POST['Email'] 
        ); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ header("Location: catalog.php?registerFailed=true"); } 
        $row = $stmt->fetch(); 
        if($row){ header("Location: catalog.php?registerFailed=email"); } 
          
        // Add row to database 
        $query = " 
            INSERT INTO customers (
                Username, 
                Password, 
                Email,
                Admin
            ) VALUES ( 
                :Username, 
                :Password, 
                :Email,
                0
            ) 
        "; 
          
        // Security measures
        $password = hash('sha256', $_POST['Password']); 
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password); } 
        $query_params = array( 
            ':Username' => $_POST['Username'], 
            ':Password' => $password, 
            ':Email' => $_POST['Email'],
        ); 
        try {  
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ header("Location: catalog.php?registerFailed=true"); } 
        $_SESSION['user'] = ['Username'=>$_POST['Username'], 'Admin'=>0];
        header("Location: catalog.php"); 
        die("Redirecting to catalog.php"); 
    } 
?>

<body>
    <div class="container">
        <div class="col-md-6 offset-md-3">
            <h2>New User Registration</h2>
            <form action="./register.php" method="post">
                    <label>Username:</label>
                    <input class="form-control" required type="text" name="Username" value="" />
                    <label>Email:</label>
                    <input class="form-control" required type="text" name="Email" value="" />
                    <label>Password:</label>
                    <input class="form-control" required type="password" name="Password" value="" />
                    <br />
                    <br />
                    <input type="submit" class="btn btn-info" value="Register" />
            </form>
        </div>
    </div>
</body>

</html>