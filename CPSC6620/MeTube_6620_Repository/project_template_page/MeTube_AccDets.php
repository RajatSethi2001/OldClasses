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
            <a href="index.php">Home</a>
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
        <div class= 'column', style ='background-color: #80ced6'>
            <h1>Account details</h1>
            <?php
                $logged_in_user = $_SESSION['username'];
                if(empty($logged_in_user)){
                    header("Location: ./MeTube_Login.php");
                }
                require "../php_scripts/db_connect.php";
                $results = mysqli_query($conn, "SELECT * FROM Users where user_id='$logged_in_user'");
                while($row = mysqli_fetch_array($results)){
                    echo "<br> <b>First name:</b> " . $row['first_name'];
                    echo "<br> <b>Last name:</b> " . $row['last_name'];
                    echo "<br> <b>User name:</b> " . $row['user_id'];
                    echo "<br> <b>Password:</b> "  . $row['user_password'];
                    echo "<br> <b>Email:</b> " . $row['email'];
                    $conn->close();
                }
            ?>
            <br>

            <!-- Once user clicks on button, edit fields become visible -->
            <button type="button" onclick="unhideEditFields()">
                Change Account Details?</button>
            
            

            <div id="update_fields", style="display: none" >
                <form action = "../php_scripts/edit_user_profile.php" method="POST" style="border:1px solid #ccc">

                    <label for="firstname"><b>First Name:</b>
                    <input type="text" placeholder="Enter your first name" id="firstname" name="firstname">
                    </label>
                    <br>

                    <label for="lastname"><b>Last Name:</b>
                    <input type="text" placeholder="Enter your last name" id="lastname" name="lastname">
                    </label>
                    <br>

                    <label for="username"><b>Username:</b>
                    <input type="text" placeholder="Create your own Username" id="username" name="username">
                    </label>
                    <br>
            
                    <label for="password"><b>Password:</b>
                    <input type="text" placeholder="Enter a unique password" id="password" name="password">
                    </label>
                    <br>

                    <label for="confirmpassword"><b>Confirm Password:</b>
                    <input type="text" placeholder="Enter a unique password" id="confirmpassword" name="confirmpassword">
                    </label>
                    <br>

                    <label for="email"><b>Email:</b>
                    <input type="email" placeholder="User Email Address" id="email" name="email">
                    </label>
                    <br>
                
                    <input type="submit" value="Update Account Information">
                </form>
            </div>


            <script>
                function unhideEditFields() {
                    var x = document.getElementById("update_fields");
                    if (x.style.display !== "none") {
                        x.style.display = "none";
                    } 
                    else {
                        x.style.display = "block";
                    }
                }
            </script>

            <h2>Your Media</h2>
            <?php
            include "../php_scripts/acc_dets.php";
            include "../php_scripts/db_connect.php";
            $get_videos = "SELECT file_path, file_title, sharing_mode, file_type FROM Multimedia_Files WHERE file_owner='$logged_in_user'";
            $sql_results = mysqli_query($conn, $get_videos);
            $rows = mysqli_fetch_all($sql_results);
            foreach ($rows as &$file_info){
                echo "<br>";
                echo "<h3> $file_info[1] </h3>";
                echo "<br>";
                $extension_arr = explode(".", $file_info[0]);
                $extension = $extension_arr[count($extension_arr) - 1];
                displayMedia($extension, $file_info[0]);
                echo "<br> Share Mode: " . $file_info[2];
                echo "<br> File type: " . $file_info[3]; 
            }
            $conn->close();
            ?>



        <h2>Your Favorites List</h2>
            <?php
            // include "../php_scripts/acc_dets.php";
            include "../php_scripts/db_connect.php";

            $user_id = $_SESSION['logged_in_id'];
            $get_videos = "SELECT * FROM Favorites_List WHERE user_numeric_id='$user_id'";
            $sql_results = mysqli_query($conn, $get_videos);
            $rows = mysqli_fetch_all($sql_results);
            
            
            
            foreach ($rows as &$file_info){
                echo "<br>";
                echo "<h3> $file_info[2] </h3>";
                echo "<br>";
                $extension_arr = explode(".", $file_info[3]);
                $extension = $extension_arr[count($extension_arr) - 1];
                displayMedia($extension, $file_info[4]);
            }
            $conn->close();
            ?>
        </div>    
     

        <div class= 'column', style ="background-color:#d5f4e6">
            <h1>Contact List</h1>

            <h3> Search for a user by their user name to add to your contact list:</h3>
            <form method="post" action = 'MeTube_AccDets.php'>
                <input type="text" placeholder="Search for a user" name="searched_user" required/>
                <input type="submit" value="Search"/>
            </form> <br><br>

            <?php 
                if(isset($_POST['searched_user']))
                {
                    require "../php_scripts/user_search.php";


                    //if user tries to add themselves to the contact list
                    if($results['user_id'] == $_SESSION['username'])
                    {
                        echo "<br>";
                        echo "You cannot add yourself to your own contact list";
                    }

                    //if results exist, display them and then ask user if they want to add them to the contact list
                    else if(!empty($results))
                    {
                        echo "<br>";
                        echo "<br>";
                        echo "User found";
                        echo "<br>";

                        printf("<div>First name: %s </div>", $results['first_name']);
                        printf("<div>Last_name:%s</div>", $results['last_name']);
                        printf("<div>User_name: %s</div>", $results['user_id']);

                        $_SESSION['added_user'] = $results['user_id'];
                        $_SESSION['added_first_name'] = $results['first_name'];
                        $_SESSION['added_last_name'] = $results['last_name'];
                        $_SESSION['added_id'] = $results['id'];
                ?>
                            <form method="post" action = '../php_scripts/add_to_contactlist.php'>
                            <label for="contact_category", required = True> <br> Pick a category to organize your contact: <br></label>
                            <select id="contact_category", name= "contact_category">
                                <option value="friend"> Friend </option>
                                <option value="family"> Family </option>
                                <option value="colleague"> Colleague </option>  
                                <option value="favorite"> Favorite </option>
                            </select>
                            <input type="submit" value="Add to contact list" name = "contactlist"/>
                            </form>
            <?php
                    }
                    
                    //if no result exists
                    else 
                    {
                        echo "<br>";
                        printf("No account found");
                    }
                }
            ?>

            <h3> Your contact list (Ordered by Colleague, Family, Favorite, and then Friend) <h3>
            
            
                <?php 
                    include '../php_scripts/db_connect.php';

                    $query_check = $_SESSION['logged_in_id'];

                    $query = "SELECT contact_user_id, contact_firstname, contact_lastname, contact_category, block_status FROM Contact_List WHERE user_id='$query_check'
                    ORDER BY contact_category";

                   

                    $result = $conn->query($query);

                    echo '<table>';
                    echo '<tr>
                                <th> Contact Username </th>
                                <th> Contact First Name </th>
                                <th> Contact Last Name </th>
                                <th> Blocked? </th>
                                <th> Category </th>
                            </tr>';
                    
                    
                    while ($row = $result->fetch_assoc())
                    {
                        $contact_username = $row['contact_user_id'];
                        $contact_firstname = $row['contact_firstname'];
                        $contact_lastname = $row['contact_lastname'];
                        $contact_category = $row['contact_category'];
                        $contact_block_status = $row['block_status'];

                        echo 
                                    "<tr><td>".$contact_username."</td><td>" . $contact_firstname . "</td><td>" . 
                                    $contact_lastname. "</td><td>" .$contact_block_status. "</td><td>".$contact_category. "</td></tr>"; 
                    }

                    echo "</table>";

                    $conn->close();
                ?>
            
            <h3> Block a contact from your contact list by using their username: (By blocking a user they will not be able to 
                 access your uploaded files and message you) </h3>
                
                 <form method="post" action = 'MeTube_AccDets.php'>
                    <input type="text" placeholder="Block a contact user" name="block_user" required/>
                    <input type="submit" value="Block"/>
                </form> <br>

                <?php
                    include '../php_scripts/db_connect.php';
                    if(isset($_POST['block_user']))
                    {
                        $block_user = $_POST['block_user'];

                        // check to see if contact exists in list
                        $sql = "SELECT contact_user_id FROM Contact_List WHERE contact_user_id='$block_user' AND user_id='$query_check'";
                        $result = mysqli_query($conn, $sql);
                        $check = mysqli_num_rows($result);

                        // check to see if contact isn't already blocked
                        $sql_2 = "SELECT block_status FROM Contact_List WHERE contact_user_id='$block_user' AND user_id='$query_check'";
                        $result_2 = mysqli_query($conn, $sql_2);
                        $row = $result_2->fetch_assoc();

                        
                        //if user is not found in the contact list
                        if($check == 0)
                        {
                            echo "<br>";
                            echo "User not found in your contact list, please try again";
                        }

                        //if user is already blocked
                        if ($row['block_status'] == "Yes")
                        {
                            echo "<br>";
                            echo "User is already blocked";
                        }


                        //else update to reflect new block status for respective user
                        else 
                        {
                            $sql = "UPDATE Contact_List SET block_status='Yes' WHERE contact_user_id='$block_user' AND user_id='$query_check'";

                            if ($conn->query($sql) === TRUE) 
                            {
                                echo "<br>";
                                echo "Contact blocked successfully, page will refresh to reflect changes";
                                echo "<script>setTimeout(\"location.href = 'MeTube_AccDets.php';\",4000);</script>";

                            } 
                            
                            else 
                            {
                                echo "<br>";
                                echo "Contact was not blocked, please try again";
                            }
                        }
                    }

                    $conn->close();
                ?>




            <h3> Unblock a contact from your contact list by using their username: </h3>
                
                 <form method="post" action = 'MeTube_AccDets.php'>
                    <input type="text" placeholder="Unlock a contact user" name="unblock_user" required/>
                    <input type="submit" value="Unblock"/>
                </form> <br>

                <?php
                    include '../php_scripts/db_connect.php';
                    if(isset($_POST['unblock_user']))
                    {
                        $unblock_user = $_POST['unblock_user'];

                        //check if user is in the contact list 
                        $sql = "SELECT contact_user_id FROM Contact_List WHERE contact_user_id='$unblock_user' AND user_id='$query_check'";
                        $result = mysqli_query($conn, $sql);
                        $check = mysqli_num_rows($result);

                        // check to see if contact isn't already unblocked
                        $sql_2 = "SELECT block_status FROM Contact_List WHERE contact_user_id='$unblock_user' AND user_id='$query_check'";
                        $result_2 = mysqli_query($conn, $sql_2);
                        $row = $result_2->fetch_assoc();

                        //if user is not found in the contact list
                        if($check == 0)
                        {
                            echo "<br>";
                            echo "User not found in your contact list, please try again";
                        }

                        //if user is already unblocked
                        if ($row['block_status'] == "No")
                        {
                            echo "<br>";
                            echo "User is already unblocked";
                        }

                    

                        else 
                        {
                            $sql = "UPDATE Contact_List SET block_status='No' WHERE contact_user_id='$unblock_user' AND user_id='$query_check'";

                            if ($conn->query($sql) === TRUE) 
                            {
                                echo "<br>";
                                echo "Contact unblocked successfully, page will refresh  to reflect changes";      
                                echo "<script>setTimeout(\"location.href = 'MeTube_AccDets.php';\",4000);</script>";
                          
                            } 
                            
                            else 
                            {
                                echo "<br>";
                                echo "Contact was not unblocked, please try again";
                            }

                            
                        }

                    }

                    $conn->close();

                ?>


            <br><br>
            <h3 style ="color: red"> Search for a user by their username to REMOVE them from your contact list:</h3>
                <form method="post" action = 'MeTube_AccDets.php'>
                    <input type="text" placeholder="Search for a user" name="remove_user" required/>
                    <input type="submit" value="Remove"/>
                </form> 

                <?php
                    include '../php_scripts/db_connect.php';
                    if(isset($_POST['remove_user']))
                    {
                        $removed_user = $_POST['remove_user'];

                        // check to see if contact exists in list
                        $sql = "SELECT contact_user_id FROM Contact_List WHERE contact_user_id='$removed_user'";
                        $result = mysqli_query($conn, $sql);
                        $check = mysqli_num_rows($result);


                        if($check == 0)
                        {
                            echo "<br>";
                            echo "User not found in your contact list, please try again";
                        }

                        else 
                        {
                            $sql = "DELETE FROM Contact_List WHERE contact_user_id = '$removed_user'";

                            if ($conn->query($sql) === TRUE) 
                            {
                                echo "<br>";
                                echo "Contact deleted successfully, page will refresh to reflect changes";
                                echo "<script>setTimeout(\"location.href = 'MeTube_AccDets.php';\",4000);</script>";

                            } 
                            
                            else 
                            {
                                echo "<br>";
                                echo "Error deleting record: " . $conn->error;
                            }
                        }
                    }

                    $conn->close();
                ?>
        </div>

    </div> 

        
<!-- </div> -->

    
</body>
</html>