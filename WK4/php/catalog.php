<?php require('head.php'); ?>
        <script>
        // Turn table into dataTable
        $(document).ready(function() {
            // var tableData = undefined;
            // $.ajax({
            //     url: "http://localhost/CIS626/WK4/php/api/book/read.php",
            // }).done(function(data){
            //     tableData = data;
                
            // });
            $('#catalog').DataTable( {
                ajax: "../php/api/book/read.php",
                // data: tableData,
                columns: [
                    { "data": "ISBN" },
                    { "data": "AuthorFirstName" },
                    { "data": "AuthorLastName" },
                    { "data": "Title" },
                    { "data": "Pages" },
                    { "data": "Publisher" },
                    { "data": "PublicationYear" },
                    { "data": "Topic" },
                ],
                searching: false
            });       
            
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
                    <th>ISBN</th>
                    <th>AuthorFirstName</th>
                    <th>AuthorLastName</th>
                    <th>Title</th>
                    <th>Pages</th>
                    <th>Publisher</th>
                    <th>PublicationYear</th>
                    <th>Topic</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
  </body>
</html>

