<?php 
    session_start();
    unset($_SESSION['posted_message']);

    if (!isset($_SESSION['username']))
    {
        echo "<script>setTimeout(\"location.href = 'MeTube_Login.php';\",0);</script>";
    }
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
            <br>
            <form method="post" action = 'MeTube_Messaging_Dashboard.php'>
                <label for ="searched_user"><b> Start a new message by finding a user to message: </b>
                <input type="text" placeholder="Search for a user" name="searched_user" required/>
                <input type="submit" value="Search"/>
            </form> 

            <?php
                if(isset($_POST['searched_user']))
                {
                    include "../php_scripts/user_search.php";
                    if(!empty($_SESSION['failed']))
                    {
                        echo $_SESSION['failed'];
                        unset($_SESSION['failed']);
                    }
                    
                    else 
                    {
                        $_SESSION['new_messaged_user'] = $results['user_id'];
                        echo "  ";
                        echo $_SESSION['new_messaged_user'];
                        echo " found";
                        echo "<br>";

                        ?>
                        <br>
                        <form method="post" action = '../php_scripts/send_new_message.php'>
                            <label for ="new_user_message"><b> Message to user </b>
                            <input type="text" placeholder="type a message" name="new_message" required/>
                            <input type="submit" value="Send"/> 
                        </form>
                        
                        <?php
                        if(!empty($_SESSION['success_message']))
                        {
                            echo $_SESSION['success_message'];
                            unset($_SESSION['success_message']);
                        }
                        
                    }
                }

            ?>
      
       
    </div>
    <br> <br>

    <!-- INBOX -->
    <div class ="m", style ='background-color: #80ced6'>
        <div style ="font-size: 40px; text-align: center"> <strong> Inbox </strong></div><br>
        <div style ="font-size: 20px; text-align: center"> <strong> Showing most recently received messages</strong></div><br>
        <div style ="font-size: 20px; text-align: center"> <strong> Click on the message to answer it</strong></div><br>  
        <?php 
            include '../php_scripts/db_connect.php';

            $temp = $_SESSION['logged_in_id'];

            

            $sql = "SELECT * FROM User_Messages WHERE sent_to = '$temp' ORDER BY sent_date DESC";
            $result = $conn->query($sql);

            echo '<table>';

            echo '<tr>
                    <th> From </th>
                    <th> Message </th>
                    <th> Time Sent </th>
                 </tr>';

            while ($row = $result->fetch_assoc())
            {
                $msg = $row['message'];
                $from = $row['sent_by'];
                $time = $row['sent_date'];

                $sql_is_blocked = "SELECT block_status from Contact_List WHERE user_id=$temp AND contact_id=$from AND block_status='Yes'";
                $blocked_result = mysqli_query($conn, $sql_is_blocked);
                $YON_result = mysqli_fetch_assoc($blocked_result);
                // echo "<br> SQL STATEMENT: $sql_is_blocked";
                // echo "<br> NUM ROWS:" . mysqli_num_rows($blocked_result);
                if (mysqli_num_rows($blocked_result)>0){
                    $sql_2 = "SELECT * FROM Users WHERE id = '$from'";
                    $result_2 = $conn->query($sql_2);
                    while ($row_2 = mysqli_fetch_array($result_2)){
                        $link = "MESSAGE BLOCKED";
                        echo 
                            "<tr><td>".$row_2['user_id']."</td><td>" . $link . "</td><td>" . 
                            $row['sent_date'].  "</td></tr>"; 
                    }
                } else {
                    $sql_2 = "SELECT * FROM Users WHERE id = '$from'";
                    $result_2 = $conn->query($sql_2);
                    while ($row_2 = mysqli_fetch_array($result_2)){

                        $link = "<a href='MeTube_Continue_Msg.php?msg=".$msg."&from=".$row_2['user_id']."&when=".$time."&from_id=".$from."'>$msg</a>";


                        echo 
                            "<tr><td>".$row_2['user_id']."</td><td>" . $link . "</td><td>" . 
                            $row['sent_date'].  "</td></tr>"; 
                        }
                }
    
            }
            echo '</table>';
            $conn->close();
        ?>   

    </div><br>

    <!-- OUTBOX -->
    <div class = "m" style ='background-color: #aaa'>
        <div style ="font-size: 40px; text-align: center"> <strong> Outbox </strong></div>
        <div style ="font-size: 20px; text-align: center"> <strong> Showing most recently sent messages</strong></div><br>

        <?php 
            include '../php_scripts/db_connect.php';

            $logged_in_user = $_SESSION['logged_in_id'];

            $sql = "SELECT * FROM User_Messages WHERE sent_by = '$logged_in_user' ORDER BY sent_date DESC";
            $result = $conn->query($sql);

            echo '<table>';

            echo '<tr>
                    <th> To </th>
                    <th> Message </th>
                    <th> Time Sent </th>
                </tr>';

            while ($row = $result->fetch_assoc())
            {

                $temp = $row['sent_to'];
                $sql_2 = "SELECT * FROM Users WHERE id = '$temp'";
                $result_2 = $conn->query($sql_2);
                while ($row_2 = mysqli_fetch_array($result_2)){

                    echo 
                        "<tr><td>".$row_2['user_id']."</td><td>" . $row['message'] . "</td><td>" . 
                        $row['sent_date'].  "</td></tr>"; 
                    }
            }
        ?>
    </div>
    

           
    
</body>
</html>


