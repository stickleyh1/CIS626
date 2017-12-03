<?php require('head.php'); ?>
        <script>
        // Turn table into dataTable
        $(document).ready(function() {
            $('#catalog').DataTable( {
                ajax: "../php/api/book/selectAll.php",
                columns: [
                    { "data": "ISBN" },
                    { "data": "AuthorName" },
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
                    <th>Author Name</th>
                    <th>Title</th>
                    <th>Pages</th>
                    <th>Publisher</th>
                    <th>Publication Year</th>
                    <th>Topic</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
  </body>
</html>

