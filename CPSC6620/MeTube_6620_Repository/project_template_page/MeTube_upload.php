<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        echo "<font size = '18'>";
        echo "Please log in first before uploading a multimedia file";
        //header("Location: MeTube_Login.php");
        echo "<script>setTimeout(\"location.href = 'MeTube_Login.php';\",4000);</script>";
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
</head>
<body>
    <div class="topnav">
        <div class="left">
            <img src='logo-5.png'></a>
            <a href="index.php">Home</a>
            <a href="MeTube_Channel.php">Channel</a>
            <a href="MeTube_Browse.php">Browse</a>
            <a href="MeTube_Browse_Channels.php">Find Channels</a>
            <a class="active" href="MeTube_upload.php">Upload File</a>
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
        <body> 
            <h1> Upload a multimedia file to MeTube</h1>
            <h2> You will need to logged in to upload a multimedia file <h2>
            <h2> Files can be at most 2MB <h2>
            <form action="../php_scripts/upload_video.php" method="POST" enctype="multipart/form-data">
            <input type='file' name='userfile' required=True>
            <br>

            <input type="text" placeholder='Name of file' name='video_name' required=True />
            <br>

            <input type="text" placeholder='Add a file description' name='file_description' required=True />
            <br>

            <label for="filetype", required = True> <br> Pick a file type to classify the file as: <br></label>
            <select id="filetype", name= "filetype">
                <option value="video"> Video </option>
                <option value="picture"> Picture </option>
                <option value="audio"> Audio </option>  
            </select>
            <br>

            <label for="category"> <br> Pick a category to classify the file as: <br></label>
            <select id="category", name= "category">
                <option value="movies"> Movies </option>
                <option value="video games"> Video Games </option>
                <option value="nature"> Nature </option>
                <option value="science"> Science </option>
                <option value="landscapes"> Landscapes </option>
                <option value="pets"> Pets </option>
            </select>
            <br>

            <label for="sharingmode"> <br> Choose a sharing mode for the multimedia file: <br></label>
            <select id="sharingmode", name= "sharingmode">
                <option value="public"> Public </option>
                <option value="private"> Private </option>
                <option value="contacts"> Contacts Only </option>  
            </select>
            <br>

            <input type="text" placeholder="Keywords for file (ADD A COMMA BETWEEN EACH KEYWORD)" name='video_tags' required=True/>
            <br>
            <input type='submit' value='Upload File'/>

            </form>

        </body>
    </div>


    <!--file name and check for duplicates-->


    </div>
    
</body>
</html>