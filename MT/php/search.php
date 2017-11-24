<?php
    require("./init.php");
    require("./functions.php");
?>
<!DOCTYPE html>
<html>
    <?php require('header.php'); ?>
        <script>
        $(document).ready(function() {
            $('#results').DataTable();
        } );    
        </script>
    </head>
  <body>
    <div class="container header">
        <img src="../images/logo.png"/>
        <h1>Library Search</h1>
    </div>
    <div class="container">
        <form id="searchForm" action="search.php" method="POST">
            <div class="row">
                <div class="col-sm-6 offset-sm-2"><input class="form-control" type="text" id="filter" name="filter" placeholder="Seach input"/></div>
                <div class="col-sm-2"><button type="submit" class="btn btn-fill btn-primary">Search</button></div>
            </div>
        </form>
        <br/>
        <?php
        $noResults = false;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isSetHandler($_POST['filter'], 'bool') && $_POST['filter'] != ''){
                $filter = $_POST['filter'];
                $filteredBooks = [];
                $books = readFileToArr('catalog.csv', ',');
                foreach ($books as $book) {
                    if(strpos($book[3], $filter) !== false || strpos($book[1], $filter) !== false || strpos($book[0], $filter) !== false || strpos($book[7], $filter) !== false || strpos($book[6], $filter) !== false){
                        array_push($filteredBooks, $book);
                    }
                }
                if(count($filteredBooks) != 0){
        ?>
                    <table id="results" class="display" cellspacing="0" width="100%">
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
                            $books = readFileToArr('catalog.csv', ',');
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
        if($noResults){
            echo '<div class="col-sm-6 offset-sm-2"><h2>No Results Found</h2></div>';
        }
        ?>          
    </div>
  </body>
</html>

