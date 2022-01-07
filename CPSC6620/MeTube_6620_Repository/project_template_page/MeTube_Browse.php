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
    </style>

</head>
<body>
    <div class="topnav">
        <div class="left">
            <img src='logo-5.png'></a>
            <a href="index.php">Home</a>
            <a href="MeTube_Channel.php">Channel</a>
            <a class="active" href="MeTube_Browse.php">Browse</a>
            <a href="MeTube_Browse_Channels.php">Find Channels</a>
            <a href="MeTube_upload.php">Upload File </a>
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

    <!-- ../php_scripts/create_video_grid.php -->
    <form action="MeTube_Browse.php" method="POST" enctype="multipart/form-data">
    <label for="title_or_keywords"><br> Search by a keyword, file name, or description: </label>
    <input type="text" placeholder='file name or keyword' name='search_string' id='search_string' />
        <label for="category"> <br> Search by category: </label>
            <select id="category", name= "category">
                <option value="all"> All Categories </option>
                <option value="movies"> Movies </option>
                <option value="video games"> Video Games </option>
                <option value="nature"> Nature </option>
                <option value="science"> Science </option>
                <option value="landscapes"> Landscapes </option>
                <option value="pets"> Pets </option>
            </select>

        <label for="filetype", required = True> <br> Search by file type: </label>
            <select id="filetype", name= "filetype">
                <option value="all"> All </option>
                <option value="video"> Video </option>
                <option value="picture"> Picture </option>
                <option value="audio"> Audio </option>  
            </select>
            <br>
        
            <div class="slidecontainer">
            <p>File size:</p> 
                0 MB <input type="range" min="0" max="2" value="2" step='0.1' id="range" name="file_size"> 2 MB    
                <p> Maximum Media Size: <span id="size"></span></p></div> 
                <script>
                    var slider = document.getElementById("range");
                    var output = document.getElementById("size");
                    output.innerHTML = slider.value;

                    slider.oninput = function() {
                    output.innerHTML = this.value;
                    }
                </script>
            <label for="SortBy", required = True> <br> How to sort the files: </label>
            <select id="SortBy", name= "SortBy">
                <option value="file_title"> Name </option>
                <option value="view_count"> Views </option>
                <option value="upload_date"> Time Uploaded </option>
                <option value="size"> Size </option>
            </select>
            <br>
            <label for="SortOrder", required = True> <br> How to sort the files: </label>
            <select id="SortOrder", name= "SortOrder">
                <option value="ASC"> Ascending </option>
                <option value="DESC"> Descending </option>
            </select>
            <br>
            <input type='submit' value='Search'/> </form><br>

        

        <?php
        include "../php_scripts/db_connect.php";
        include "../php_scripts/create_video_grid.php";
        video_grid($conn);
        $conn->close();
        ?>

        
    </div>


    
</body>
</html>