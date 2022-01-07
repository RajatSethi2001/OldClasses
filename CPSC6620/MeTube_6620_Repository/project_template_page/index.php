<?php 
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="template_style.css">
    <style>
        {
            box-sizing: border-box;
        }
        /* Set additional styling options for the columns*/
        .column {
        float: left;
        width: 50%;
        }

        .main:after {
        content: "";
        display: table;
        clear: both;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="topnav">
        <div class="left">
            <img src='logo-5.png'></a>
            <a class='active' href="index.php">Home</a>
            <a href="MeTube_Channel.php">Channel</a>
            <a href="MeTube_Browse.php">Browse</a>
            <a href="MeTube_Browse_Channels.php">Find Channels</a>
            <a href="MeTube_upload.php">Upload File</a>
        </div>
        <!-- Add User profile picture on the right header -->
        <div class="right">
            <img src="loginIcon.png"></a>
            <a href="MeTube_Login.php">Login</a>
            <a href="MeTube_SignUp.php">Sign Up </a>
            <a href="../php_scripts/logout.php"> Log Out </a>
            <a href="MeTube_AccDets.php"> Profile Details </a>
        </div>

        


    </div>
    <div class="main">
        <!-- <body> Sample Text here</body> -->

        <!-- This displays a successfully logged in message -->
        <?php 
            if (!empty($_SESSION['username']))
            {
                echo $_SESSION['username'];
                echo " ";
                echo $_SESSION['success'];
            }
 
        ?>

        <!-- button do direct user to messaging page  -->
        <button onclick="location.href = 'MeTube_Messaging_Dashboard.php'">Message users </button>
        <button onclick="location.href = 'MeTube_Playlists.php'">Playlists </button>
      
        <div class="column", style = 'background-color:cyan'>
            <!-- Display most viewed videos -->
            <?php
            include '../php_scripts/db_connect.php';
            include '../php_scripts/home_page.php';

            show_most_viewed($conn, 5);

            ?>
        </div>
        
        <div class='column' style='background-color:darkgreen'>
            <!-- Display most recent videos -->
            <?php
            
            show_most_recent($conn, 5);
            show_recent_subscribed($conn, 5);

            $conn->close();

            ?>
        </div>

    </div>
    
</body>
</html>