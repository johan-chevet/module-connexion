<?php
require_once "dbconfig.php";
require_once "init-session.php";

if (!isset($_SESSION["user"])) {
    header("Location: index.html");
    exit();
} else {
    $user = $_SESSION["user"];
}

if (isset($_POST["submit-update"])) {
    $params = ["login", "firstname", "lastname"];
    foreach ($params as $param) {
        $input = $_POST[$param];
        if (!isset($input) || trim($input) === "") {
            $errors[$param] = "$param should not be empty";
            continue;
        }
        $input = trim($input);
        if ($param === "login" && strtolower($input) !== strtolower($user["login"])) {
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
    if (!isset($errors)) {
        $stmt = $db->prepare("UPDATE utilisateurs SET login=:login, prenom=:firstname, nom=:lastname
         WHERE id=:id");
        $stmt->bindParam("login", $_POST["login"]);
        $stmt->bindParam("firstname", $_POST["firstname"]);
        $stmt->bindParam("lastname", $_POST["lastname"]);
        $stmt->bindParam("id", $user["id"]);
        if ($stmt->execute()) {
            $user["login"] = $_POST["login"];
            $user["prenom"] = $_POST["firstname"];
            $user["nom"] = $_POST["lastname"];
            $_SESSION["user"] = $user;
            $info = "<p>Votre profil a été mis à jour</p>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profil</title>
</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>
    <form method="post">
        <div class="update-form">
            <div class="register-form-content">
                <h1>Modifier son profil</h1>
                <?php if (isset($info)) {
                    echo $info;
                }
                ?>
                <label for="login">Login: </label>
                <input type="text" name="login" id="login" value=<?= htmlspecialchars($user["login"]) ?> />
                <?php if (isset($errors["login"])) {
                    echo "<p>" . $errors["login"] . "</p>";
                }
                ?>
                <label for="firstname">Firstname: </label>
                <input type="text" name="firstname" id="firstname" value=<?= htmlspecialchars($user["prenom"]) ?> />
                <?php if (isset($errors["firstname"])) {
                    echo "<p>" . $errors["firstname"] . "</p>";
                }
                ?>
                <label for="lastname">Lastname: </label>
                <input type="text" name="lastname" id="lastname" value=<?= htmlspecialchars($user["nom"]) ?> />
                <?php if (isset($errors["lastname"])) {
                    echo "<p>" . $errors["lastname"] . "</p>";
                }
                ?>
                <input type="submit" name="submit-update" value="Envoyer" />
            </div>
        </div>
    </form>
</body>

</html>