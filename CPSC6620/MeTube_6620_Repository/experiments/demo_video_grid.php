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
    include "../php_scripts/create_video_grid.php";
    include "../php_scripts/db_connect.php";

    // $get_video = "SELECT file_path FROM Multimedia_Files WHERE file_title = 'Cat Video'";
    // $sql = mysqli_query($conn, $get_video);
    // $row = mysqli_fetch_row($sql);
    // echo "<br>";
    // print_r($row);
    // echo "<br>";
    // print($row[0]);
    // echo "<br>";
    // // use one_video function in create_video_browser
    // one_video($row[0], $width=200, $height=200);
    // echo "<br>";
    // // use video grid
    
    // $get_videos = "SELECT file_path FROM Multimedia_Files WHERE file_type='video'";
    // $sql = mysqli_query($conn, $get_videos);

    // video_grid($sql);
    // $row = mysqli_fetch_all($sql);
    // echo "<br>";
    // print_r($row[0]);
    // echo "<br>";
    // print_r($row[1]);

    // foreach ($row as &$file_path){
    //     echo "<br>";
    //     print_r($file_path[0]);
    //     echo "<br>";
    //     one_video($file_path[0], $width=200, $height=200);
    // }

    video_grid($conn);

    $conn->close();
    ?>
    
</body>
</html>