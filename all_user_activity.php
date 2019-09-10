<!DOCTYPE html>
<html>

<head>
    <title>
        All user activities
    </title>
    <style>
        .log_attributes{
            
        }
        .log_attributes table {
            border-collapse: collapse;
            width: 100%;
            height: 100%;
            
        }
        

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            position: sticky;top:0;
            background-color: #4CAF50;
            color: white;
        }

    </style>
</head>

<body>

</body>

</html>
<?php
require_once('./database.php');
require_once("./functions.php");
/* It will print activities of all users */
display_users_activity();
?>