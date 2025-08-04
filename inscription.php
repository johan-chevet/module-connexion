<?php
require_once "dbconfig.php";

if (isset($_POST["submit-register"])) {
    $params = ["login", "password", "password-confirmation", "firstname", "lastname"];
    foreach ($params as $param) {
        $input = $_POST[$param];
        if (!isset($input) || trim($input) === "") {
            $errors[$param] = "$param should not be empty";
            continue;
        }
        $input = trim($input);
        if ($param === "login") {
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $input)) {
                $errors[$param] = "Login can only contains letters, numbers and '_'";
                continue;
            }
            $stmt = $db->prepare("SELECT id FROM utilisateurs WHERE LOWER(login)=:login");
            $stmt->bindValue("login", strtolower($input));
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $errors[$param] = "Login unavailable";
            }
        }
    }
    if (
        isset($_POST["password"]) && isset($_POST["password-confirmation"]) &&
        $_POST["password"] !== $_POST["password-confirmation"]
    ) {
        $errors["password-confirmation"] = "passwords doesn't match";
    } else if (!isset($errors)) {
        $stmt = $db->prepare("INSERT INTO utilisateurs (login, password, prenom, nom)
        VALUES (:login, :password, :firstname, :lastname)");
        $stmt->bindParam("login", $_POST["login"]);
        $stmt->bindParam("password", $_POST["password"]);
        $stmt->bindParam("firstname", $_POST["firstname"]);
        $stmt->bindParam("lastname", $_POST["lastname"]);
        if ($stmt->execute()) {
            // Redirect to login page
            header('Location: connexion.php');
            exit();
        }
    }
}
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
                <h1>Inscription</h1>
                <label for="login">Login: </label>
                <input type="text" name="login" id="login" value="karim" />
                <?php if (isset($errors["login"])) {
                    echo "<p>" . $errors["login"] . "</p>";
                }
                ?>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" value="123" />
                <?php if (isset($errors["password"])) {
                    echo "<p>" . $errors["password"] . "</p>";
                }
                ?>
                <label for="password-confirmation">Password confirmation: </label>
                <input type="password" name="password-confirmation" id="password-confirmation" value="123" />
                <?php if (isset($errors["password-confirmation"])) {
                    echo "<p>" . $errors["password-confirmation"] . "</p>";
                }
                ?>
                <label for="firstname">Firstname: </label>
                <input type="text" name="firstname" id="firstname" value="karimm" />
                <?php if (isset($errors["firstname"])) {
                    echo "<p>" . $errors["firstname"] . "</p>";
                }
                ?>
                <label for="lastname">Lastname: </label>
                <input type="text" name="lastname" id="lastname" value="PPPPP" />
                <?php if (isset($errors["lastname"])) {
                    echo "<p>" . $errors["lastname"] . "</p>";
                }
                ?>
                <input type="submit" name="submit-register" value="Send" />
            </div>
        </div>
    </form>
</body>

</html>