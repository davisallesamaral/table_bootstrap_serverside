# table_bootstrap_serverside
Table with sort and search etc, using Bootstrap (For results with many records) - Serve-Side

Server-Side:
Let's set Index:

Note that I will use the same formatting as the previous post, so I will not go into that much further. The important thing is how to run the query from the server side. So basically what will be changed is the following code snippet:

<script type = "text / javascript" language = "javascript">
   $ (document) .ready (function () {
   var dataTable = $ ('# myTable'). DataTable ({
                     "processing": true,
                     "serverSide": true,
                     "ajax": {
                           url: "phpmysql_serverside.php" // The PHP code, which will mount the JSON for the table
                           type: "post", // Method, default get
                           error: function () {// Error Handling
                                             $ (". myTable-error"). html ("");
                                             <tr> <tr> <th colspan = "3"> No results were found! </ t> </ tr> </ tbody> ');
                                             $ ("# myTabela_processing"). css ("display", "none");
                             }
                         }
                     });
     });
 </ script>
Did you notice the url: "phpmysql_serverside.php" excerpt? Well, here's the magic!

But first let's see the full index:

<! DOCTYPE html>
<html>
 <title> Logs Query </ title>
 <head>
 <link rel = "stylesheet" type = "text / css" href = "css / jquery.dataTables.css">
 <script type = "text / javascript" language = "javascript" src = "js / jquery.js"> </ script>
 <script type = "text / javascript" language = "javascript" src = "js / jquery.dataTables.js"> </ script>
 <script type = "text / javascript" language = "javascript">
   $ (document) .ready (function () {
   var dataTable = $ ('# myTable'). DataTable ({
                     "processing": true,
                     "serverSide": true,
                     "ajax": {
                           url: "phpmysql_serverside.php" // The PHP code, which will mount the JSON for the table
                           type: "post", // Method, default get
                           error: function () {// Error Handling
                                             $ (". myTable-error"). html ("");
                                             <tr> <tr> <th colspan = "3"> No results were found! </ t> </ tr> </ tbody> ');
                                             $ ("# myTabela_processing"). css ("display", "none");
                             }
                         }
                     });
     });
  </ script>
</ head>
<body>
  <center> <h1> Fiergs Integrations Log </ h1> </ center>
  <div class = "table-responsive">
  <table id = "myTable" class = "display table" width = "100%">
  <thead>
    <tr>
      <th> Field 1 </ th>
      <th> Field 2 </ th>
      <th> Field 3 </ th>
    </ tr>
  </ thead>
 </ table>
 </ div>
 </ body>
</ html>
So now let's mount the server side, where will be mounted records that will appear in the table:
Starting the connection to the database:

<? php
  $ servername = "localhost";
  $ username = "user";
  $ password = "your";
  $ dbname = "test";
Connecting the database:

     $ conn = mysqli_connect ($ servername, $ username, $ password, $ dbname);
Storing the array (GET / POST):

      $ requestData = $ _REQUEST;
This information comes from FRAMEWORK, here are some variables that will be useful in our example and are passed by ajax:

order [0] [column]: 0 - Tells which column you requested to sort (starts from scratch);
order [0] [dir]: desc - Tells whether the ordering is asc or desc, this is increasing or decreasing;
start: 0 - Informs from which record the data will be displayed;
length: 10 - Informs how many records will be displayed at a time in the query;
search [value]: Informs the values ​​entered in the Search field
Now let's create an array of the table or table fields you want to search and demonstrate on your grid:

$ columns = array (
                 0 => 'FIELD1',
                 1 => 'CAMPO2',
                 2 => 'CAMPO3'
            );
Let's then get the total of the existing record in the query, without any kind of filter. This total will be demonstrated as follows: (filtered from 99,999 total entries)

$ sql = "SELECT FIELD1, FIELD2, FIELD3";
 $ sql. = "FROM table";
 $ query = mysqli_query ($ conn, $ sql);
 $ recordsTotal = mysqli_num_rows ($ query);
Let us now begin to prepare so that we can use the records passed via parameter, in the case the search and the page.

 $ sql. = "WHERE 1 = 1";

In order not to query in vain, let's first check if the search field has any value. If there is a search parameter, put the Likes:

if (! empty ($ requestData ['search'] ['value'])) {
 $ sql = "AND (CAMPO1 LIKE '". $ requestData [' search '] [' value ']. "%'";
 $ sql. = "OR FILE2 LIKE '" $ requestData [' search '] [' value ']. "%'";
 $ sql. = "OR FILE3 LIKE '" $ requestData [' search '] [' value ']. "%')";
 }
Now let's capture the amount of records found from the information coming from the search:

 $ query = mysqli_query ($ conn, $ sql);
 $ recordsFiltered = mysqli_num_rows ($ query);
Showing 1 to 10 of 502 entries (filtered from 97,132 total entries) 502 would be the result of "mysqli_num_rows ($ query);" passed to the variable $ recordsFiltered;

Now let's prepare to sort the selection according to the column that is marked:

$ sql. = "ORDER BY". $ columns [$ requestData ['order'] [0] ['column']]. "" $ requestData ['order'] [0] ['dir'];
$ RequestData ['order'] [0] ['column'] tells which column is being indexed, $ requestData ['order'] [0] ['dir'] says whether the order will be asc / desc

Let's now deal with pagination:

 $ incrow = ($ requestData ['start'] + 1);
 $ fimrow = ($ requestData ['start'] + $ requestData ['length']);
 $ sql = "LIMIT". $ requestData ['start']. ", $ queryData ['length']." ";
 $ query = mysqli_query ($ conn, $ sql);
Now let's run the select that will populate the records that will appear in the table:

preparing the array;

 $ data = array ();
  while ($ row = mysqli_fetch_array ($ query)) {
                    $ nestedData = array ();
                    $ nestedData [] = $ row ["FIELD1"];
                    $ nestedData [] = $ row ["FIELD2"];
                    $ nestedData [] = $ row ["FIELD3"];
                    $ data [] = $ nestedData;
        }
Let's mount the array that will serve as the basis for mounting the JSON:

$ json_data = array (
                                      "draw" => intval ($ requestData ['draw'])
                                       "recordsTotal" => intval ($ recordsTotal),
                                       "recordsFiltered" => intval ($ recordsFiltered),
                                       "date" => $ data
     );
json_encode - Returns the JSON representation of a value. Returns the string containing the JSON representation of a value.

echo json_encode ($ json_data);
 ?>
And then we finish the code!
