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

    <form action="" method="POST" enctype="multipart/form-data">
    <label for="SortBy", required = True> <br> Sort the files by: </label>
            <select id="SortBy", name= "SortBy">
                <option value="file_title"> Name </option>
                <option value="view_count"> Views </option>
                <option value="upload_date"> Time Uploaded </option>
                <option value="size"> Size </option>
            </select>
            <br>
            <input type='hidden' name='playlist_name' value=<?php echo $_GET['playlist_name']; ?>/>

            <label for="SortOrder", required = True> <br> By what order: </label>
            <select id="SortOrder", name= "SortOrder">
                <option value="ASC"> Ascending </option>
                <option value="DESC"> Descending </option>
            </select>
            <br>
            <input type='submit' value='Search'/> </form><br>
    
  
    
    <?php
        include "../php_scripts/acc_dets.php";
        include "../php_scripts/db_connect.php";    

    

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $playlist =  $_SESSION['TEMP'];
            echo "<h2> Playlist: ".$playlist."</h2>";
        
            $user_id = $_SESSION['logged_in_id'];
            
            //get the current playlist id
            $sql = "SELECT playlist_id FROM Playlist_Tracker WHERE user_id='$user_id' AND playlist_name='$playlist'";
            $results = mysqli_query($conn, $sql);
            $row = $results->fetch_assoc();
            $playlist_id =  $row['playlist_id'];


            //get all the file ids associated with that playlist
            $sql_2 = "SELECT video_id FROM File_Playlist WHERE playlist_id='$playlist_id'";
            $results_2 = mysqli_query($conn, $sql_2);

            // empty string to store all vid ids
            $all_vid_ids = "(";
            // add ids to the list
            while ($row_2 = $results_2->fetch_assoc())
            {
                    $id =  $row_2['video_id'];
                    $all_vid_ids = $all_vid_ids . $id . ",";
            }
            // tac on last parenth and get rid of last comma
            $all_vid_ids = rtrim($all_vid_ids, ",");
            $all_vid_ids = $all_vid_ids . ")";
                   
            //get all the file information associated with those file ids
            $SortBy = $_POST['SortBy'];
            $SortOrder = $_POST['SortOrder'];
            $sql_3 = "SELECT * FROM Multimedia_Files WHERE id IN $all_vid_ids ORDER BY $SortBy $SortOrder";
            echo "SQL Query: " . $sql_3;
            $results_3 = mysqli_query($conn, $sql_3);

            //iterate through the query above to display all the files
            while($row_3 = $results_3->fetch_assoc())
            {
                echo "<br>";
                $path = $row_3['file_path'];

                $extension_arr = explode(".", $row_3['file_path']);
                $extension = $extension_arr[count($extension_arr) - 1];
                echo "<h2>". $row_3['file_title']. "</h2>";
                
                echo "<form method='post' action = '../php_scripts/delete_playlist_file.php'>
                <input type='hidden' name='playlist_id' value='$playlist_id'r/>
                <input type='hidden' name='video_id' value='$id'r/>
                <input type='submit' value='Remove from playlist'/>  </form> ";
                displayMedia($extension, $path);               
                echo "<br>";
            }
    
        }

        else 
        {

            $playlist = $_GET['playlist_name'];
            $_SESSION['TEMP'] = $playlist;
            echo "<h2> Playlist: ".$playlist."<h2>";
            $user_id = $_SESSION['logged_in_id'];
            
            $sql = "SELECT playlist_id FROM Playlist_Tracker WHERE user_id='$user_id' AND playlist_name='$playlist'";
            $results = mysqli_query($conn, $sql);

            $row = $results->fetch_assoc();
            $playlist_id =  $row['playlist_id'];

            $sql_2 = "SELECT video_id FROM File_Playlist WHERE playlist_id='$playlist_id'";
            $results_2 = mysqli_query($conn, $sql_2);

            while ($row_2 = $results_2->fetch_assoc())
            {
                $id =  $row_2['video_id'];
            

          
                $sql_3 = "SELECT * FROM Multimedia_Files WHERE id='$id'";
                $results_3 = mysqli_query($conn, $sql_3);
                while($row_3 = $results_3->fetch_assoc())
                {
                    echo "<br>";
                    $path = $row_3['file_path'];

                    $extension_arr = explode(".", $row_3['file_path']);
                    $extension = $extension_arr[count($extension_arr) - 1];
                    echo "<h2>". $row_3['file_title']. "</h2>";
                        
                    echo "<form method='post' action = '../php_scripts/delete_playlist_file.php'>
                    <input type='hidden' name='playlist_id' value='$playlist_id'r/>
                    <input type='hidden' name='video_id' value='$id'r/>
                    <input type='submit' value='Remove from playlist'/>  </form> ";
                    displayMedia($extension, $path);               
                    echo "<br>";
                
                }
            }
        }
        $conn->close();
    ?>
    </div>
   
</body>
</html>

