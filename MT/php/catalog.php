<?php require('head.php'); ?>
        <script>
        // Turn table into dataTable
        $(document).ready(function() {
            $('#catalog').DataTable();
        } );    
        </script>
    </head>
  <body>
    <div class="header">
        <img src="../images/logo.png"/>
        <h1>Library Catalog</h1>
    </div>
    
    <nav class="navbar navbar-inverse bg-primary">
    <!-- Navbar content -->
    </nav>
    <!-- Content Container -->
    <div class="container">
        <!-- Search Button to replace built-in search bar -->
        <a id="searchBtn" href="search.php"><button class="btn btn-primary btn-sm tableBtn">Search</button></a>
        <!-- Table to display full listing -->
        <table id="catalog" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author Name</th>
                    <th>ISBN</th>
                    <th>Publication Year</th>
                    <th>Publisher</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Call function to convert file to 2d array
                $books = readFileToArr('catalog.csv', ',');
                // Loop through array to output each into table
                foreach ($books as $book) {
                ?>
                <tr>
                    <th><?php echo $book[3] == ""? 'Unlisted': $book[3] ?></th>
                    <th><?php echo ($book[2]== "" && $book[1] == "")? 'Unlisted': $book[2]." ".$book[1] ?></th>
                    <th><?php echo $book[0] == ""? 'Unlisted': $book[0] ?></th>
                    <th><?php echo $book[7] == ""? 'Unlisted': $book[7] ?></th>
                    <th><?php echo $book[6] == ""? 'Unlisted': $book[6] ?></th>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
  </body>
</html>

