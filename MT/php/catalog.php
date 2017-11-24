<?php require('head.php'); ?>
        <script>
        // Turn table into dataTable
        $(document).ready(function() {
            $('#catalog').DataTable();
        } );    
        </script>
    </head>
  <body>
    <!-- Include navbar -->
    <?php require('../navbar.html'); ?>
    <!-- Content Container -->
    <div class="container">
        <h2>Catalog Listing</h2>
        <!-- Table to display full listing -->
        <table id="catalog" class="display" cellspacing="0" width="100%">
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
                // Call function to convert file to 2d array
                $books = readFileToArr('catalog.csv', ',');
                // Loop through array to output each into table
                foreach ($books as $book) {
                ?>
                <tr>
                    <td><?php echo $book[3] == ""? 'Unlisted': $book[3] ?></td>
                    <td><?php echo ($book[2]== "" && $book[1] == "")? 'Unlisted': $book[2]." ".$book[1] ?></td>
                    <td><?php echo $book[0] == ""? 'Unlisted': $book[0] ?></td>
                    <td><?php echo $book[7] == ""? 'Unlisted': $book[7] ?></td>
                    <td><?php echo $book[6] == ""? 'Unlisted': $book[6] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
  </body>
</html>

