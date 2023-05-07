<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/styles/dashboard.css"/>
    <link rel="stylesheet" href="./public/styles/index.css"/>
    <script src="https://kit.fontawesome.com/ea6d546e2a.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="logged-users-table-wrapper">

        <div class="index-top">
            <h1 class="welcome-text" data-username=<?= $username ?>> Welcome <?= $username ?></h1>
            <button class="logout-button">Logout</button>
        </div>

        <h3 class="table-title"> 
            <i class="fa fa-users"></i> 
            <span class="logges-users-text">Logged Users Table</span> 
        </h3>

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
            </tbody>
        </table>
    </div>

    <div class="user-details-pop-wrapper invisible">
        <div class="user-details-pop-container">
            <div class="logged-user-details-container">

                

            </div>
        </div>
    </div>
    
</body>
<script type="module" src="./public/scripts/pages/index.js"></script>
</html>