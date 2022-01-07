<?php
include '../php_scripts/db_connect.php';
include '../php_scripts/media_page.php';
include '../php_scripts/generate_recommendations.php';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".metabtn").click(function(){
                $(".reveal").toggle();
            });
        });
    </script>
    <style>
        .right_column {
            padding-left:5px;
            padding-right:5px;
            padding-top:17px;
            float:left;
            display:table;
            max-width:460px;
        }
        .comment {
            width:900px;
            border: 3px solid #000000;
            margin-top: 10px;
            font-family:sans-serif;
            font-size:24px;
            background-color:beige;
        }
        .commentBox {
            width:1015px;
            height: 200px;
            border: 3px solid #000000;
            font-family:sans-serif;
            font-size:24px;
            text-align:top;
            display:block;
            resize:none;
        }
        .download {
            width:460px;
            height:100px;
            background-color:limegreen;
            text-align: center;
            display:table-cell;
            vertical-align: middle;
            color:white;
            font-size:60px;
            font-family:sans-serif;
            border: 3px solid #000000;
            cursor: pointer;
        }
        .download:hover {
            background-color:seagreen;
        }
        .metabtn {
            width:1020px;
            height:50px;
            background-color:lightgrey;
            text-align: center;
            display:table-cell;
            vertical-align: middle;
            color:black;
            font-size:30px;
            font-family:sans-serif;
            border: 3px solid #000000;
            cursor: pointer;
            -webkit-transition: all 300ms;
	        -moz-transition: all 300ms;
            transition: all 300ms;
        }
        .metabtn:hover {
            background-color:grey;
        }
        .reveal {
            display: none;
            border: 3px solid #000000;
            padding-top: 2px;
            font-family:sans-serif;
            background-color:beige;
            width: 1024px;
        }
        .replybox {
            width:700px;
            height: 50px;
            border: 3px solid #000000;
            font-family:sans-serif;
            font-size:24px;
            text-align:top;
            resize:none;
            float:left;
            
        }
        .star {
            font-size:97px;
            float:left;
        }
        #star1 {
            color:<?php echo $stars[0]?>
        }
        #star2 {
            color:<?php echo $stars[1]?>
        }
        #star3 {
            color:<?php echo $stars[2]?>
        }
        #star4 {
            color:<?php echo $stars[3]?>
        }
        #star5 {
            color:<?php echo $stars[4]?>
        }
        .rating_box {
            width:458px;
            height:35px;
            text-align:center;
            vertical-align: middle;
            border:1px solid #000000;
            float:left;
            font-size:30px;
            font-family:sans-serif;
            background-color:beige;
            padding-top:2px;
            padding-bottom:2px;
        }

        .avg_star {
            width:90.25px;
            height:150px;
            border: 1px solid #8B0000;
            background-color:lightblue;
            text-align:center;
            font-size:97px;
            float:left;
        }
        #avg_star1 {
            color:<?php echo $average_stars[0]?>
        }
        #avg_star2 {
            color:<?php echo $average_stars[1]?>
        }
        #avg_star3 {
            color:<?php echo $average_stars[2]?>
        }
        #avg_star4 {
            color:<?php echo $average_stars[3]?>
        }
        #avg_star5 {
            color:<?php echo $average_stars[4]?>
        }
    </style>
</head>
<body>
    <div class="topnav">
        <div class="left">
            <img src='logo-5.png'>
            <a class='active' href="index.php">Home</a>
            <a href="#channel">Channel</a>
            <a href="MeTube_Browse.php">Browse</a>
            <a href="MeTube_upload.php">Upload File</a>
            <a href="MeTube_Browse_Channels.php">Find Channels</a>
        </div>
        <!-- Add User profile picture on the right header -->
        <div class="right">
        <img src="loginIcon.png">
            <a href="MeTube_Login.php">Login</a>
            <a href="MeTube_SignUp.php">Sign Up </a>
            <a href="../php_scripts/logout.php"> Log Out </a>
            <a href="MeTube_AccDets.php"> Profile Details </a>
        </div>
    
    </div>
    <div class="media" style="padding-top:5px; float:left; max-width=1024px;">
        <?php displayMedia($extension, $path); ?>
       <!-- <h1 class="title"><?php echo $name ?></h1> -->
            <div class="metabtn">File Metadata</div>
            <?php getData($query) ?>
            <form action="../php_scripts/Send_Comment.php" method="post">
                <textarea class="commentBox" name="comment" rows="14" cols="10" wrap="hard" placeholder="Add a Comment!" required></textarea><br>
                <input type="hidden" name="file_id" value="<?php echo $file_id ?>" />
                <input type="hidden" name="parent" value="0" />
                <input type="hidden" name="level" value="1" />
                <input type="submit" value="Submit" style="font-size:30px">
            </form>
            <?php getComments($file_id) ?>
    </div>
    <div class="right_column">
        <form method="post" action="../php_scripts/download_file.php?filename=<?php echo $filename ?>" >
            <button class="download" type="submit"><i class="fa fa-download"></i> Download</button>
        </form>
        <div class="rating_box">Your Rating</div>
        <form method="post" action="../php_scripts/review.php">
            <input type="hidden" name="file_id" value="<?php echo $file_id ?>" />
            <button class="star" id="star1" name="star1" type="submit">&bigstar;</button>
            <button class="star" id="star2" name="star2" type="submit">&bigstar;</button>
            <button class="star" id="star3" name="star3" type="submit">&bigstar;</button>
            <button class="star" id="star4" name="star4" type="submit">&bigstar;</button>
            <button class="star" id="star5" name="star5" type="submit">&bigstar;</button>
        </form>
        <div class="rating_box">Average Rating</div>
        <div class="average_ratings">
            <div class="avg_star" id="avg_star1">&bigstar;</div>
            <div class="avg_star" id="avg_star2">&bigstar;</div>
            <div class="avg_star" id="avg_star3">&bigstar;</div>
            <div class="avg_star" id="avg_star4">&bigstar;</div>
            <div class="avg_star" id="avg_star5">&bigstar;</div>
        </div>

        <br>
    </div>
    <h2> Recommended Files <h2>
    <?php generate_recommended($file_id, $user_id, $category, $conn) ?>
    
</body>
</html>