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
    <div class='main'>
    <br>
            <form method="post" action = 'MeTube_Playlists.php'>
                <label for ="new_playlist"><b> Create a new playlist by giving it a name: </b>
                <input type="text" placeholder="Give your new playlist a name" name="playlist_name" required/>
                <input type="submit" value="Create"/>
            </form> 
            <?php
                include '../php_scripts/db_connect.php';
                {
                   if($_SERVER["REQUEST_METHOD"] == "POST")
                   {
                        $playlist_name =  $_POST['playlist_name'];
                        $curr_user_id = $_SESSION['logged_in_id'];


                        //search for any playlist name duplicates
                        $sql = "SELECT * FROM Playlist_Tracker WHERE playlist_name='$playlist_name' and user_id='$curr_user_id'";
                        $results = mysqli_query($conn, $sql);
                        $playlist_duplicates = mysqli_num_rows($results);

                        if ($playlist_duplicates>0)
                        {
                            echo "<br>";
                            echo "A playlist with this name already exists, enter a unique name or rename that specific playlist";
                        }

                        else if ($playlist_name == " ")
                        {
                            exit();
                        }

                        else
                        {
                            $sql_2 = "INSERT INTO Playlist_Tracker (user_id, playlist_name) VALUES ('$curr_user_id', '$playlist_name')";
                            $results = mysqli_query($conn, $sql_2);
                            echo "New playlist created successfully";
                        }
                   }

                }
            ?>

            <br><br>

            <h2> Your Created Playlists <h2>
            <h3> Click on the playlist name to access the files in that playlist <h3>
            <h3> If you want to rename your playlist, type a new name below the respective playlist <h3>
            <?php
                include '../php_scripts/db_connect.php';

                $curr_user_id = $_SESSION['logged_in_id'];

                $sql = "SELECT * FROM Playlist_Tracker WHERE user_id='$curr_user_id'";

                $results = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($results))
                {
                    $t = $row['playlist_name'];
                    $_SESSION['PN'] = $t;
                    $x = $row['playlist_id'];
                    $link = "<a href='MeTube_Individual_Playlist.php?playlist_name=".$t."&playlist_id=".$x."'>$t</a>";

                    echo "<br>";
                    echo $link. "       ";
                    echo "<form method='post' action = '../php_scripts/delete_playlists.php'>
                    <input type='hidden' name='curr_playlist_name' value='$t'r/>
                    <input type='hidden' name='curr_playlist_id' value='$x'r/>
                    <input type='submit' value='Delete Playlist'/>  </form> ";

   
                    echo "<form method='post' action = '../php_scripts/rename_playlist.php'>
                    <label for ='rename_playlist'>
                    <input type='hidden' name='curr_playlist_name' value='$t'r/>
                    <input type='hidden' name='curr_playlist_id' value='$x'r/>
                    <input type='text' placeholder='Rename your playlist' name='new_playlist_name' required r/>
                    <input type='submit' value='Rename'/>  </form> ";
            
                    echo "<br><br>";
                }


            ?>


   
</body>
</html>


