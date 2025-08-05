<?php
require_once "dbconfig.php";
require_once "init-session.php";

function getFormValue($name): string
{
    return htmlspecialchars($_POST[$name] ?? "");
}

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["submit-login"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];
    if (isset($login) && isset($password)) {
        $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE login=:login LIMIT 1");
        $stmt->bindParam("login", $_POST["login"]);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $user =  $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user["password"])) {
                unset($user["password"]);
                $_SESSION["user"] = $user;
                header('Location: index.php');
                exit();
            } else {
                $errors["login"] = 'Invalid credentials';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>
    <form method="post">
        <div class="login-form">
            <div class="login-form-content">
                <h1>Connexion</h1>
                <label for="login">Login: </label>
                <input type="text" name="login" id="login" required value=<?= getFormValue("login") ?>>
                <?php if (isset($errors["login"])) {
                    echo "<p>" . $errors["login"] . "</p>";
                }
                ?>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" required value=<?= getFormValue("password") ?>>
                <?php if (isset($errors["password"])) {
                    echo "<p>" . $errors["password"] . "</p>";
                }
                ?>
                <input type="submit" name="submit-login" value="Send" />
            </div>
        </div>
    </form>
</body>

</html>