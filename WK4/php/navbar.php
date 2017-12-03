<!-- Navbar wrapper -->
<nav class="navbar navbar-expand-lg navbar-inverse bg-primary">
    <!-- Navbar logo link -->
    <a class="navbar-brand topBar" href="catalog.php">
        <img src="../images/logo.png" class="d-inline-block align-top logo" alt=""> Local Library
    </a>
    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavLinks" aria-controls="navbarNavLinks"
        aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa fa-2x fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavLinks">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="catalog.php">Home</a>
            <a class="nav-item nav-link" href="search.php">Search</a>
            <?php if(!isset($_SESSION['user'])){?>
                <li class="dropdown nav-item nav-link">
                    <a class="dropdown-toggle nav-item nav-dropdown" href="#" data-toggle="dropdown">Register<strong class="caret"></strong></a>
                    <div class="dropdown-menu" style="padding: 15px; padding-bottom: 5px;">
                        <form action="register.php" method="post"> 
                            <label>Username:</label>
                            <input type="text" class="form-control" name="Username" value="" /> 
                            <label>Email:</label>
                            <input type="email" class="form-control" name="Email" value="" /> 
                            <label>Password:</label>
                            <input type="password" class="form-control" name="Password" value="" /> 
                            <br />
                            <input type="submit" class="btn btn-info" value="Register" /> 
                        </form> 
                    </div>
                </li>
                <li class="dropdown nav-item nav-link">
                    <a class="dropdown-toggle nav-item nav-dropdown" href="#" data-toggle="dropdown">Log In <strong class="caret"></strong></a>
                    <div class="dropdown-menu" style="padding: 15px; padding-bottom: 5px;">
                        <form action="login.php" method="post"> 
                            <label>Username:</label>
                            <input type="text" class="form-control" name="Username" value="" /> 
                            <label>Password:</label>
                            <input type="password" class="form-control" name="Password" value="" /> 
                            <a href="#">Reset password?</a>
                            <br />
                            <input type="submit" class="btn btn-info" value="Login" /> 
                        </form> 
                    </div>
                </li>
            <?php }else{ 
                if($_SESSION['user']['Admin'] == 1){ ?>
                    <a class="nav-item nav-link" href="#">Admin Panel</a>
                <?php } ?>
                <a class="nav-item nav-link" href="#">My Books</a>
                <a class="nav-item nav-link" href="logout.php">Logout</a>
            <?php } ?>
        </div>
    </div>
</nav>