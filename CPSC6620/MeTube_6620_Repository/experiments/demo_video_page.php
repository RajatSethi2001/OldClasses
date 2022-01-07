<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include "../php_scripts/db_connect.php";
    include "../php_scripts/video_page.php";
    $file_info = get_video_info(5, $conn);
    $conn->close();
    ?>
    <!-- I'm putting the html here in the code so we can adjust its styling and position -->
    <h1> <?php echo $file_info[1]; ?> </h1>
    <video width='1280' height="720" controls>
        <source src=<?php echo $file_info[0]; ?>>
    </video>
    <!-- Display the comments -->
    
    
</body>
</html>