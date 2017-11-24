<?php require('head.php'); ?>
        <script>
        // Turn table into dataTable
        $(document).ready(function() {
            $('#results').DataTable();
        } );    
        </script>
    </head>
  <body>
    <!-- Include navbar -->
    <?php require('../navbar.html'); ?>
    <!-- Content Container -->
    <div class="container">
        <h2>Catalog Search</h2>
        <!-- Form for searching file -->
        <form id="searchForm" action="search.php" method="POST">
            <div class="row">
                <div class="col-sm-6 offset-sm-2"><input class="form-control" type="text" id="filter" name="filter" placeholder="Seach input"/></div>
                <div class="col-sm-2"><button type="submit" class="btn btn-fill btn-primary">Search</button></div>
            </div>
        </form>
        <br/>
        <?php
        $noResults = false;
        // Check if data is posted
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Check if filter is blank
            if(isSetHandler($_POST['filter'], 'bool') && $_POST['filter'] != ''){
                $filter = $_POST['filter'];
                $filteredBooks = [];
                // Call function to convert file to 2d array
                $books = readFileToArr('catalog.csv', ',');
                // Loop through array to filter array based on form input
                foreach ($books as $book) {
                    if(strpos($book[3], $filter) !== false || strpos($book[1], $filter) !== false || strpos($book[0], $filter) !== false || strpos($book[7], $filter) !== false || strpos($book[6], $filter) !== false){
                        array_push($filteredBooks, $book);
                    }
                }
                // Display table if there are results
                if(count($filteredBooks) != 0){
        ?>
                    <table id="results" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author Name</th>
                                <th>ISBN</th>
                                <th>Year</th>
                                <th>Publisher</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Loop through filtered array to output into table
                            foreach ($filteredBooks as $book) {
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
        <?php   
                } else{
                    $noResults = true;
                } 
            }else{
                $noResults = true;
            } 
        } 
        // If there are no results display message
        if($noResults){
            echo '<div class="col-sm-6 offset-sm-2"><h2>No Results Found</h2></div>';
        }
        ?>          
    </div>
  </body>
</html>

