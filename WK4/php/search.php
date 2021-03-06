<?php require('head.php'); ?>
        <script>
        // Turn table into dataTable
        $(document).ready(function() {
            $('#results').hide();

            $('#searchBtn').click(function(){
                $('#results').DataTable( {
                    ajax: "../php/api/book/search.php?filter="+$('#filter').val(),
                    columns: [
                        { "data": "ISBN" },
                        { "data": "AuthorName" },
                        { "data": "Title" },
                        { "data": "Pages" },
                        { "data": "Publisher" },
                        { "data": "PublicationYear" },
                        { "data": "Topic" },
                    ],
                    searching: false,
                    bDestroy:true
                });
                $('#results').show();
            })
        } );    
        </script>
    </head>
  <body>
    <!-- Include navbar -->
    <?php require('./navbar.php'); ?>
    <!-- Content Container -->
    <div class="container">
        <h2>Catalog Search</h2>
        <!-- Form for searching file -->
        <form id="searchForm" action="search.php" method="POST">
            <div class="row">
                <div class="col-sm-6 offset-sm-2"><input class="form-control" type="text" id="filter" name="filter" placeholder="Seach input"/></div>
                <div class="col-sm-2"><button id="searchBtn" name="searchBtn" type="button" class="btn btn-fill btn-primary">Search</button></div>
            </div>
        </form>
        <br/>
        <table id="results" class="display" cellspacing="0" width="100%">
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

