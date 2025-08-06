<?php
require_once "dbconfig.php";
require_once "init-session.php";

/* If user is not admin, redirect to home page */
if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== "admin") {
    header("location: index.php");
    exit();
}

/* Fetch all users */
// TODO try catch, check if users set
$res = $db->query("SELECT id, login, prenom, nom FROM utilisateurs");
$users = $res->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin page</title>
</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>
    <h1>Liste des utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Login</td>
                <td>Prenom</td>
                <td>Nom</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <?php foreach ($user as $key => $value): ?>
                        <td><?= htmlspecialchars($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>