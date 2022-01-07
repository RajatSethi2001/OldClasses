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
            <a href="#channel">Channel</a>
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

    </div><br><br>

    

    <?php
        $_SESSION['msg'] = $_GET['msg'];
        $_SESSION['from'] = $_GET['from'];
        $_SESSION['time'] = $_GET['when'];
        $_SESSION['from_id'] = $_GET['from_id'];
        
        echo "<b>",$_SESSION['from'],"</b>", ": ", $_SESSION['msg'];
        echo "<br>";
        echo "Sent at : ", $_SESSION['time'];
    ?><br><br> <br>


    <?php

    
       if (isset($_SESSION['posted_message'])){
            echo "<div style='text-align:right'>";
            echo $_SESSION['posted_message'], ": ";
            echo "<b>",$_SESSION['username'],"</b>";
            echo "<br>";
            echo "Sent at : ", $_SESSION['pm_time'];
       }
   
        echo "</div>";
    ?>


<form method="post" action = '../php_scripts/reply_to_message.php'>
        <label for ="new_user_message"><b> Message to user </b>
        <input type="text" placeholder="type a message" name="new_message" required/>
        <input type="submit" value="Send"/> 
</form>
<br><br>
Go back to messaging dashboard once you have replied

    
</body>
</html>


