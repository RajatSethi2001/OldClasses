<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> This page will force you to download a file <h1>
    <?php
    include "../php_scripts/download_file.php";
    $test_path = "../Multimedia_Files/dog.mov";
    download($test_path);
    
    ?>
    
</body>
</html>