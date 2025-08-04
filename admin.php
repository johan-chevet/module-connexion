<?php
require_once "dbconfig.php";

session_name("module-connexion");
session_start();

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
    <title>Admin</title>
</head>

<body>
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
                        <td><?= $value ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>