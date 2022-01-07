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

        </div>
  
    </div>
    <div class="main">

        <form action = "../php_scripts/sign_up.php" method="POST" style="border:1px solid #ccc">
            <h1>Sign up</h1>
            <p>Use the form below to sign up</p>
            

            <label for="email"><b>Email:</b>
            <input type="email" placeholder="User Email Address" id="email" name="email">
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
            <label for="firstname"><b>First Name:</b>
            <input type="text" placeholder="Enter your first name" id="firstname" name="firstname">
            </label>
            <br>
            <label for="lastname"><b>Last Name:</b>
            <input type="text" placeholder="Enter your last name" id="lastname" name="lastname">
            </label>
            <br>
            <input type="submit" value="Submit">
        </form>

        
    </div>


        


    </div>
    
</body>
</html>