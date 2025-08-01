<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="post">
        <div class="register-form">
            <div class="register-form-content">
                <h1>Register</h1>
                <label for="login">Login: </label>
                <input type="text" name="login" id="login" />
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" />
                <label for="firstname">Firstname: </label>
                <input type="text" name="firstname" id="firstname" />
                <label for="lastname">Lastname: </label>
                <input type="text" name="lastname" id="lastname" />
                <input type="submit" name="submit-register" value="Send" />
            </div>
        </div>
    </form>
</body>

</html>