<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RVS Inter College</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1 style="color:#4682B4; font-weight:300">Welcome Back<br><b>RVS Inter College</b></h1>
            <h1>Login Please</h1>
            <div class="alert" id="error-message" style="display: none;"></div>
            <form action="login.php" method="post">
                <div class="textbox">
                    <input type="text" placeholder="Username" name="username" autofocus style="width:95% !important;" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Password" name="password" style="width:95% !important;" required>
                </div>
                <button type="submit" class="btn" style="background:#12385b !important;" id="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>