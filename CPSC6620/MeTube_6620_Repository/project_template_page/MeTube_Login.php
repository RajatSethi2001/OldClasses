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
        <form name="login" action = '../php_scripts/login.php' method="POST" style="border:1px solid #ccc">
            <h1>Login</h1>
            <p>Use the form below to login to your account</p>
            <label for='username'>
                <input type="text" placeholder="Enter your username here" id="username" name="username" required>
            </label>
            <br>
            <label for="password">
                <input type="password" placeholder="Enter your password here" id="password" name="password" required>
            </label>
            <br>
            <input type="submit" value="login"> 
            <p>Don't have an account? <a href="MeTube_SignUp.php">Sign up for one now</a></p>

        </form>
    </div>
    
</body>
</html>