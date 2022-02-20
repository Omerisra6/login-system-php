<?php
    session_start(); 
    $username = $_SESSION['username']; 

    if ( ! isset( $username ) ) {
        header("Location: http://localhost:8000/client/forms/login.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css"/>
    <script src="https://kit.fontawesome.com/ea6d546e2a.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="logged-users-table-wrapper">
        <h1> Welcome <?= $username ?></h1>
        <h3> <i class="fa fa-users"></i> Logged Users Table </h3>

        <table>
            <thead>
                <tr>
                    <th> USERNAME </th>
                    <th> LOGIN TIME </th>
                    <th> LAST UPDATE </th>
                    <th> USER`S IP </th>
                </tr>
            </thead>
            <tbody class="logged-users-table-body">
                <tr>
                    <td> Omer </td>
                    <td> 2022-02-17 11:26:50 </td>
                    <td> 2022-02-17 11:26:50 </td>
                    <td> 127.0.1.1</td>
                </tr>
            </tbody>
        </table>
    </div>
    
</body>
<script type="text/javascript" src="./index.js"></script>
</html>