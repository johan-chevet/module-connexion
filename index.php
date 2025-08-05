<?php
session_name("module-connexion");
session_start();

if (isset($_POST["disconnect"])) {
    unset($_SESSION["user"]);
    header("Location: index.php");
    exit();
}
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>

<body>

    <header>
        <nav class="navbar">
            <h2>Module de connexion</h2>
            <ul>
                <li>
                    <a href="index.php">Accueil</a>
                </li>
                <?php if (!isset($user)): ?>
                    <li>
                        <a href="connexion.php">Se connecter</a>
                    </li>
                    <li>
                        <a href="inscription.php">Créer un compte</a>
                    </li>
                <?php else: ?>
                    <?php if (strtolower($user["login"]) === "admin"): ?>
                        <li>
                            <a href="admin.php">Admin Page</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="profil.php"><?= $user["login"] ?></a>
                    </li>
                    <li>
                        <form method="post">
                            <input type="submit" name="disconnect" value="Déconnexion">
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>

</html>